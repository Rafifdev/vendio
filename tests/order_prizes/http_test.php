<?php
// Tests module HTTP behavior without bootstrapping the legacy app/database.
define('BASEPATH', __DIR__);
require dirname(__DIR__,2).'/modules/order_prizes/libraries/Order_prize_http.php';
function log_message($level,$message) {}
class InputStub {
    public $verb='GET'; public $fields=[]; public $cookies=[];
    public function method($upper) { return $this->verb; }
    public function post($name=null,$xss=false) { return $name===null ? $this->fields : ($this->fields[$name] ?? null); }
    public function get($name=null,$xss=false) { return $name===null ? $this->fields : ($this->fields[$name] ?? null); }
    public function cookie($name) { return $this->cookies[$name] ?? null; }
}
class OutputStub {
    public $status; public $body; public $headers=[];
    public function enable_profiler($value) {}
    public function set_header($value) { $this->headers[]=$value; return $this; }
    public function set_status_header($value) { $this->status=$value; return $this; }
    public function set_content_type($value,$charset) { return $this; }
    public function set_output($value) { $this->body=json_decode($value,true); return $this; }
}
class SecurityStub {
    public function get_csrf_token_name() { return 'csrf_name'; }
    public function get_csrf_hash() { return str_repeat('a',32); }
}
class ConfigStub { public function item($name) { return 'csrf_cookie'; } }
class Endpoint {
    use Order_prize_http;
    public $input; public $output; public $security; public $config;
    public function __construct() { $this->input=new InputStub(); $this->output=new OutputStub(); $this->security=new SecurityStub(); $this->config=new ConfigStub(); }
    public function run($method='GET',$work=null) { $this->prize_json($work ?: function () { return ['ok'=>true]; },$method); }
}
$count=0;
function check($ok,$message) { global $count; if (!$ok) throw new RuntimeException('FAIL: '.$message); $count++; }
$ep=new Endpoint(); $ep->run();
check($ep->output->status===200 && $ep->output->body['success'],'200 JSON success');
check(isset($ep->output->body['csrf']['hash']),'CSRF metadata in response');
check(in_array('Cache-Control: no-store',$ep->output->headers,true),'no cache');
$ep->run('POST'); check($ep->output->status===405,'wrong method rejected');
$ep->input->verb='POST'; $ep->run('POST'); check($ep->output->status===403,'missing csrf rejected');
$ep->input->fields=['csrf_name'=>str_repeat('a',32)]; $ep->run('POST'); check($ep->output->status===403,'csrf cookie required');
$ep->input->cookies=['csrf_cookie'=>str_repeat('b',32)]; $ep->run('POST'); check($ep->output->status===403,'csrf mismatch rejected');
$ep->input->cookies=['csrf_cookie'=>str_repeat('a',32)]; $ep->run('POST'); check($ep->output->status===200,'valid csrf accepted');
$ep->input->fields=['csrf_name'=>['array attack']]; $ep->run('POST'); check($ep->output->status===403,'csrf array rejected');
$ep->input->verb='GET';
foreach ([401,403,404,409,422,429] as $status) {
    $ep->run('GET',function () use ($status) { throw new Order_prize_error('expected',$status); });
    check($ep->output->status===$status && !$ep->output->body['success'],'domain HTTP status '.$status);
}
check(in_array('Retry-After: 900',$ep->output->headers,true),'rate limit retry header');
$ep->run('GET',function () { throw new RuntimeException('secret SQL and PII'); });
check($ep->output->status===500,'unexpected error HTTP 500');
check(strpos(json_encode($ep->output->body),'secret')===false,'unexpected error details not leaked');
// Framework route regression: old catchall duplicates $3; explicit route preserves ID.
$route=[]; define('APPPATH',dirname(__DIR__,2).'/application/'); define('ADMIN_NAMESPACE_URL','administrator');
require APPPATH.'config/routes.php';
foreach (['administrator/order_prizes/save/prizes/42'=>'order_prizes/backend/order_prizes/save/prizes/42',
    'administrator/order_prizes/records/spins'=>'order_prizes/backend/order_prizes/records/spins',
    'administrator/order_prizes/fulfill/9'=>'order_prizes/backend/order_prizes/fulfill/9'] as $url=>$expected) {
    $resolved=null;
    foreach ($route as $key=>$value) {
        if (!is_string($value)) continue;
        $pattern='#^'.str_replace([':any',':num'],['[^/]+','[0-9]+'],$key).'$#';
        if (preg_match($pattern,$url)) { $resolved=preg_replace($pattern,$value,$url); break; }
    }
    check($resolved===$expected,'explicit route '.$url);
}
// Exercise the actual admin controller, not just the shared transport trait.
class AauthStub {
    public $loggedIn=false;
    public function is_loggedin() { return $this->loggedIn; }
    public function get_user() { return (object)['id'=>7]; }
}
class PrizesSpy {
    public $writes=0; public $actor; public $input;
    public function listing($entity,$filters) { return ['items'=>[], 'total'=>0]; }
    public function save_campaign($input,$id,$actor) { $this->writes++; $this->actor=$actor; $this->input=$input; return ['id'=>$id]; }
    public function fulfill($id,$input,$actor) { $this->writes++; $this->actor=$actor; return ['id'=>$id]; }
}
class ControllerLoaderStub { public function model($path,$alias) {} }
class Admin extends Endpoint {
    public $load; public $aauth; public $prizes; public $permissions=[];
    public function __construct() { parent::__construct(); $this->load=new ControllerLoaderStub(); $this->aauth=new AauthStub(); $this->prizes=new PrizesSpy(); }
    public function is_allowed($permission,$redirect=true) { return $this->aauth->loggedIn && in_array($permission,$this->permissions,true); }
}
require dirname(__DIR__,2).'/modules/order_prizes/controllers/backend/Order_prizes.php';
$admin=new Order_prizes();
$admin->records('spins'); check($admin->output->status===401,'anonymous cannot list PII');
$admin->aauth->loggedIn=true; $admin->records('audit'); check($admin->output->status===403,'logged in without read permission denied');
$admin->permissions=['order_prizes_view']; $admin->records('spins'); check($admin->output->status===200,'reader can list');
$admin->input->verb='POST'; $admin->input->fields=['csrf_name'=>str_repeat('a',32), 'actor_id'=>999]; $admin->input->cookies=['csrf_cookie'=>str_repeat('a',32)];
$admin->save('campaigns',1); check($admin->output->status===403 && $admin->prizes->writes===0,'reader cannot manage');
$admin->fulfill(1); check($admin->output->status===403 && $admin->prizes->writes===0,'reader cannot fulfill');
$admin->import_orders(); check($admin->output->status===403,'reader cannot import trusted orders');
$admin->permissions=['order_prizes_manage']; $admin->save('campaigns',1);
check($admin->output->status===200 && $admin->prizes->writes===1 && $admin->prizes->actor===7,'authorized write uses session actor, not input actor');
$admin->save('spins',1); check($admin->output->status===404 && $admin->prizes->writes===1,'cannot forge spin via generic save');
$admin->save('campaigns','not-an-id'); check($admin->output->status===422,'strict entity ID');
$admin->permissions=['order_prizes_fulfill']; $admin->fulfill(1); check($admin->output->status===200,'fulfillment permission allowed');
$admin->save('campaigns',1); check($admin->output->status===403,'fulfillment permission cannot manage settings');
echo "PASS: $count HTTP/route/authorization assertions\n";
