<?php
/**
 * Run ONLY against an isolated MySQL database named order_prizes_test.
 * OP_TEST_DSN='mysql:host=127.0.0.1;dbname=order_prizes_test;charset=utf8mb4'
 * OP_TEST_USER=root OP_TEST_PASSWORD=... php tests/order_prizes/integration_test.php
 * Tests production service/SQL through a minimal PDO adapter for CI's DB interface.
 */
define('BASEPATH', __DIR__);
date_default_timezone_set('Asia/Jakarta');
function log_message($level, $message) { fwrite(STDERR, "$level: $message\n"); }
class TestResult {
    private $rows;
    public function __construct($rows) { $this->rows=$rows; }
    public function row_array() { return $this->rows[0] ?? []; }
    public function row() { return (object)$this->row_array(); }
    public function result_array() { return $this->rows; }
}
class TestDatabase {
    public $db_debug=false;
    public $pdo;
    private $failed=false;
    private $lastError=['code'=>0];
    public function __construct() {
        $dsn=getenv('OP_TEST_DSN');
        if (!$dsn || !preg_match('/(?:^|;)dbname=order_prizes_test(?:;|$)/', $dsn)) throw new RuntimeException('Set OP_TEST_DSN to isolated database order_prizes_test; this test deletes its module tables.');
        $this->pdo=new PDO($dsn,getenv('OP_TEST_USER') ?: 'root',getenv('OP_TEST_PASSWORD') ?: '', [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES=>false]);
    }
    public function query($sql, $params=[]) {
        try {
            $statement=$this->pdo->prepare($sql); $statement->execute($params);
            return new TestResult($statement->columnCount() ? $statement->fetchAll(PDO::FETCH_ASSOC) : []);
        } catch (PDOException $e) { $this->failed=true; $this->lastError=['code'=>$e->errorInfo[1] ?? 0]; return false; }
    }
    public function error() { return $this->lastError; }
    public function trans_begin() { $this->failed=false; return $this->pdo->beginTransaction(); }
    public function trans_status() { return !$this->failed; }
    public function trans_commit() { return $this->pdo->commit(); }
    public function trans_rollback() { return $this->pdo->inTransaction() ? $this->pdo->rollBack() : true; }
    public function insert_id() { return $this->pdo->lastInsertId(); }
    public function escape_like_str($s) { return str_replace(['!','%','_'],['!!','!%','!_'],$s); }
}
class TestLoader { public function database() {} }
class CI_Model {
    public $db; public $load;
    public function __construct() { $this->db=new TestDatabase(); $this->load=new TestLoader(); }
}
require dirname(__DIR__, 2) . '/modules/order_prizes/models/Model_order_prizes.php';
$count=0;
function check($condition, $message) { global $count; if (!$condition) throw new RuntimeException('FAIL: '.$message); $count++; }
function rejects(callable $fn, $status, $message) {
    try { $fn(); } catch (Order_prize_error $e) { check($e->http_status===$status, $message.' status '.$e->http_status); return; }
    throw new RuntimeException('FAIL (did not reject): '.$message);
}
$m=new Model_order_prizes();
$pdo=$m->db->pdo;
$tables=['order_prize_audit','order_prize_spins','order_prize_tokens','order_prize_orders','order_prize_items','order_prize_campaigns','order_prize_rate_limits'];
foreach ($tables as $table) $pdo->exec('DROP TABLE IF EXISTS '.$table);
// Legacy menu/permission tables are fixtures in this disposable database only.
$pdo->exec('CREATE TABLE IF NOT EXISTS aauth_perms (id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(100),definition TEXT)');
$pdo->exec('CREATE TABLE IF NOT EXISTS menu (id INT AUTO_INCREMENT PRIMARY KEY,label VARCHAR(200),type VARCHAR(200),icon_color VARCHAR(200),link VARCHAR(200),sort INT,parent INT,icon VARCHAR(50),menu_type_id INT,active INT)');
$sql=file_get_contents(dirname(__DIR__,2).'/database/create_order_prizes.sql');
$pdo->exec($sql); $pdo->exec($sql);
check((int)$pdo->query("SELECT COUNT(*) FROM aauth_perms WHERE name LIKE '%order_prizes%'")->fetchColumn()===4,'idempotent permission seed');
check((int)$pdo->query("SELECT COUNT(*) FROM menu WHERE link='{admin_url}/order_prizes'")->fetchColumn()===1,'idempotent menu seed');
$c=$m->save_campaign(['slug'=>'test','name'=>'Test','shop_ref'=>'shop-a','starts_at'=>date('Y-m-d H:i:s',time()-86400),'ends_at'=>date('Y-m-d H:i:s',time()+86400),'terms'=>'Test terms'],0,1);
$cid=(int)$c['id'];
rejects(function () use ($m,$cid) { $m->save_campaign(['status'=>'active'],$cid,1); },422,'active campaign needs fallback');
check($m->listing('campaigns',[])['items'][0]['status']==='draft','activation rollback');
$fallback=$m->save_prize(['campaign_id'=>$cid,'name'=>'Free voucher','kind'=>'voucher','weight'=>100],0,1);
$m->save_campaign(['status'=>'active'],$cid,1);
rejects(function () use ($m,$fallback) { $m->save_prize(['active'=>0],$fallback['id'],1); },422,'cannot remove active fallback');
function order_input($cid,$number,$extra=[]) { return array_merge(['campaign_id'=>$cid,'order_number'=>$number,'phone'=>'081234567890','status'=>'completed','revenue'=>100000,'profit'=>20000,'ordered_at'=>date('Y-m-d H:i:s',time()-60)],$extra); }
$o=$m->save_order(order_input($cid,'ORDER-001'),0,1);
rejects(function () use ($m,$cid) { $m->save_order(order_input($cid,'ORDER-001'),0,1); },409,'duplicate marketplace order');
rejects(function () use ($m) { $m->verify('test','ORDER-001','081299999999',0); },422,'wrong phone');
$v=$m->verify('test','ORDER-001','+6281234567890',0);
$token=$v['token'];
check(strlen($token)===64,'strong token');
check($pdo->query('SELECT token_hash FROM order_prize_tokens LIMIT 1')->fetchColumn()!==$token,'token stored hashed');
$r=$m->spin($token); $retry=$m->spin($token);
check($r['id']===$retry['id'],'retry returns same spin');
check(!isset($r['phone']) && !isset($r['order_number']) && !isset($r['prize_cost']) && !isset($r['decision_json']),'public result no PII or internal financial data');
$c=$m->listing('campaigns',[])['items'][0];
check((int)$c['spin_count']===1 && (int)$c['revenue_total']===100000 && (int)$c['profit_total']===20000,'metrics counted once');
check((int)$pdo->query('SELECT COUNT(*) FROM order_prize_spins')->fetchColumn()===1,'one persisted spin');
$v2=$m->verify('test','ORDER-001','081234567890',0);
check($v2['already_spun'] && $v2['result']['id']===$r['id'],'verify again recovers result');
rejects(function () use ($m,$token) { $m->spin($token); },401,'rotated token invalidated');
$token=$v2['token'];
check($m->spin($token)['id']===$r['id'],'rotated token cannot reroll');
rejects(function () use ($m,$o) { $m->save_order(['revenue'=>200000],$o['id'],1); },409,'financial snapshot immutable after spin');
rejects(function () use ($m,$r) { $m->fulfill($r['id'],['prize_status'=>'processing'],1); },409,'must claim before fulfillment');
rejects(function () use ($m,$r) { $m->fulfill($r['id'],['broadcast_status'=>'queued'],1); },409,'broadcast requires consent');
rejects(function () use ($m,$r) { $m->fulfill($r['id'],['prize_status'=>'void','notes'=>'Cancel'],1); },422,'void cannot leave claim pending');
check($m->result_or_claim($token,true)['claim_status']==='claimed','claim submitted');
check($m->result_or_claim($token,true)['claim_status']==='claimed','claim retry idempotent');
$m->fulfill($r['id'],['prize_status'=>'processing','follow_up_status'=>'contacted'],1);
$m->fulfill($r['id'],['prize_status'=>'sent','notes'=>'Tracking TEST123'],1);
$m->fulfill($r['id'],['prize_status'=>'delivered','follow_up_status'=>'closed'],1);
rejects(function () use ($m,$r) { $m->fulfill($r['id'],['prize_status'=>'reserved'],1); },409,'cannot reverse delivered');
// All-or-nothing import, even when failure occurs after the first valid row.
$before=(int)$pdo->query('SELECT COUNT(*) FROM order_prize_orders')->fetchColumn();
rejects(function () use ($m,$cid) { $m->import_orders($cid,[order_input($cid,'IMPORT-1'),order_input($cid,'ORDER-001')],1); },409,'duplicate import rollback');
check((int)$pdo->query('SELECT COUNT(*) FROM order_prize_orders')->fetchColumn()===$before,'import leaves zero partial rows');
rejects(function () use ($m,$cid) { $m->import_orders($cid,[order_input($cid,'IMPORT-1'),order_input($cid,'IMPORT-2',['phone'=>'08***'])],1); },422,'invalid import rollback');
$m->import_orders($cid,[order_input($cid,'IMPORT-1'),order_input($cid,'IMPORT-2',['profit'=>''])],1);
check($m->listing('orders',['q'=>'IMPORT-'])['total']===2,'search and import');
check($m->listing('orders',['q'=>"' OR 1=1 --"])['total']===0,'parameterized search');
check($m->listing('orders',['q'=>'%'])['total']===0,'literal LIKE wildcards');
check(count($m->listing('orders',['limit'=>1,'page'=>2])['items'])===1,'pagination');
$m->save_order(order_input($cid,'CANCELLED',['status'=>'cancelled']),0,1);
rejects(function () use ($m) { $m->verify('test','CANCELLED','081234567890',0); },422,'cancelled order denied');
$ref=$m->save_order(order_input($cid,'REFUND-1'),0,1);
$vt=$m->verify('test','REFUND-1','081234567890',0);
$m->save_order(['status'=>'refunded'],$ref['id'],1);
rejects(function () use ($m,$vt) { $m->spin($vt['token']); },401,'edit invalidates unspent token');
$expire=$m->verify('test','IMPORT-1','081234567890',1);
$er=$m->spin($expire['token']);
$pdo->exec("UPDATE order_prize_spins SET claim_deadline='2000-01-01 00:00:00' WHERE id=".(int)$er['id']);
check($m->result_or_claim($expire['token'])['claim_status']==='expired','effective claim expiration');
check($m->listing('spins',['claim_status'=>'expired'])['total']===1,'expiry filter without cron');
rejects(function () use ($m,$expire) { $m->result_or_claim($expire['token'],true); },409,'expired claim denied');
$m->fulfill($er['id'],['claim_status'=>'rejected','prize_status'=>'void','notes'=>'Expired'],1);
$m->save_campaign(['status'=>'ended'],$cid,1);
check(!$m->public_campaign('test')['is_open'],'closed campaign metadata supports result recovery');
check($m->verify('test','ORDER-001','081234567890',0)['already_spun'],'recover after campaign end');
rejects(function () use ($m) { $m->verify('test','IMPORT-2','081234567890',0); },409,'ended campaign blocks new spins');
$m->save_campaign(['status'=>'active'],$cid,1);
$ex=$m->verify('test','IMPORT-2','081234567890',0);
$pdo->exec("UPDATE order_prize_tokens SET expires_at='2000-01-01 00:00:00' WHERE token_hash=".$pdo->quote(hash('sha256',$ex['token'])));
rejects(function () use ($m,$ex) { $m->spin($ex['token']); },401,'expired token denied');
for ($i=0;$i<2;$i++) $m->rate_limit('test','identity',2);
rejects(function () use ($m) { $m->rate_limit('test','identity',2); },429,'rate limit enforced');
check((int)$pdo->query('SELECT COUNT(*) FROM order_prize_audit')->fetchColumn()>10,'audit recorded');
check(strpos(implode('', $pdo->query('SELECT detail_json FROM order_prize_audit')->fetchAll(PDO::FETCH_COLUMN)), $token)===false,'no raw token in audit');
// Roll back an award when any final write fails (simulated DB failure via trigger).
$fail=$m->verify('test','IMPORT-2','081234567890',0);
$spinsBefore=$pdo->query('SELECT COUNT(*) FROM order_prize_spins')->fetchColumn();
$countsBefore=$pdo->query('SELECT spin_count FROM order_prize_campaigns WHERE id='.$cid)->fetchColumn();
$pdo->exec("CREATE TRIGGER op_test_fail BEFORE INSERT ON order_prize_audit FOR EACH ROW SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='forced failure'");
try { $m->spin($fail['token']); throw new LogicException('Expected DB failure'); } catch (RuntimeException $e) { check(!($e instanceof LogicException),'write failure thrown'); }
$pdo->exec('DROP TRIGGER op_test_fail');
check($pdo->query('SELECT COUNT(*) FROM order_prize_spins')->fetchColumn()===$spinsBefore,'spin rollback on failure');
check($pdo->query('SELECT spin_count FROM order_prize_campaigns WHERE id='.$cid)->fetchColumn()===$countsBefore,'counter rollback on failure');
$m->spin($fail['token']);
// Race two connections for a final stock unit. Fallback weight 1 vs paid prize 1,000,000.
if (function_exists('pcntl_fork')) {
    $premium=$m->save_prize(['campaign_id'=>$cid,'name'=>'Last unit','stock'=>1,'cost'=>1,'weight'=>1000000],0,1);
    $jobs=[];
    foreach (['RACE-1','RACE-2'] as $number) { $m->save_order(order_input($cid,$number),0,1); $jobs[]=$m->verify('test',$number,'081234567890',0)['token']; }
    // Close inherited MySQL sockets BEFORE fork. Each child establishes its own connection.
    $m=null; $pdo=null;
    $children=[];
    foreach ([$jobs[0],$jobs[0],$jobs[1]] as $job) {
        $pid=pcntl_fork();
        if ($pid===-1) throw new RuntimeException('fork failed');
        if ($pid===0) { try { $worker=new Model_order_prizes(); $worker->spin($job); exit(0); } catch (Throwable $e) { fwrite(STDERR,$e->getMessage()); exit(1); } }
        $children[]=$pid;
    }
    foreach ($children as $pid) { pcntl_waitpid($pid,$status); check(pcntl_wexitstatus($status)===0,'parallel request succeeded'); }
    $m=new Model_order_prizes(); $pdo=$m->db->pdo;
    check((int)$pdo->query("SELECT COUNT(*) FROM order_prize_spins WHERE order_number IN ('RACE-1','RACE-2')")->fetchColumn()===2,'parallel retry no duplicate spin');
    check((int)$pdo->query('SELECT COUNT(*) FROM order_prize_spins WHERE prize_id='.(int)$premium['id'])->fetchColumn()<=1,'last unit never oversold');
    check((int)$pdo->query('SELECT stock FROM order_prize_items WHERE id='.(int)$premium['id'])->fetchColumn()>=0,'stock never negative');
} else echo "SKIP: parallel requests (pcntl not installed)\n";
echo "PASS: $count MySQL integration assertions\n";
