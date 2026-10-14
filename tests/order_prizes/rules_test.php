<?php
// Standalone: php tests/order_prizes/rules_test.php (PHP 7.4+, 64-bit).
define('BASEPATH', __DIR__);
require dirname(__DIR__, 2) . '/modules/order_prizes/libraries/Order_prize_rules.php';
date_default_timezone_set('Asia/Jakarta');
$count = 0;
function check($condition, $message) {
    global $count;
    if (!$condition) throw new RuntimeException('FAIL: ' . $message);
    $count++;
}
function rejects(callable $fn, $message) {
    try { $fn(); } catch (Order_prize_error $e) { check(true, $message); return; }
    throw new RuntimeException('FAIL (did not reject): ' . $message);
}
check(Order_prize_rules::phone('0812-3456-7890') === '6281234567890', 'local phone');
check(Order_prize_rules::phone('+62 812 3456 7890') === '6281234567890', 'international phone');
foreach (['081***90','1234','+86123123456','62812345678901234',[],null,'abcdefgh'] as $bad) rejects(function () use ($bad) { Order_prize_rules::phone($bad); }, 'invalid phone');
check(Order_prize_rules::order_number(' abcd-123_9 ') === 'ABCD-123_9', 'canonical order');
foreach (["abc' OR 1=1",'../test','X',[]] as $bad) rejects(function () use ($bad) { Order_prize_rules::order_number($bad); }, 'invalid order');
check(Order_prize_rules::integer('', 'profit', -100, 100, true) === null, 'unknown profit');
check(Order_prize_rules::integer('-20','profit',-100,100) === -20, 'negative profit retained');
foreach (['1.5','1e5','NaN',-1,[],true,'9223372036854775808'] as $bad) rejects(function () use ($bad) { Order_prize_rules::integer($bad,'cost',0,100); }, 'invalid integer');
check(Order_prize_rules::datetime('2026-10-14T09:00','date') === '2026-10-14 09:00:00', 'datetime local');
foreach (['2026-02-30 09:00:00','2026-13-01 09:00:00','2026-10-14 25:00:00','yesterday'] as $bad) rejects(function () use ($bad) { Order_prize_rules::datetime($bad,'date'); }, 'strict datetime');
rejects(function () { Order_prize_rules::text("\xFF",'text',100); }, 'invalid UTF-8');
$campaign = ['name'=>'October','slug'=>'october','shop_ref'=>'shop-a','starts_at'=>'2026-10-01 00:00:00','ends_at'=>'2026-10-31 23:59:59'];
check(Order_prize_rules::campaign($campaign)['status'] === 'draft', 'draft by default');
rejects(function () use ($campaign) { Order_prize_rules::campaign($campaign + ['status'=>'active']); }, 'active requires terms');
rejects(function () use ($campaign) { Order_prize_rules::campaign(array_merge($campaign,['ends_at'=>'2026-09-01 00:00:00'])); }, 'end before start');
rejects(function () use ($campaign) { Order_prize_rules::campaign(array_merge($campaign,['slug'=>'../../a'])); }, 'invalid slug');
$p = Order_prize_rules::prize(['campaign_id'=>1,'name'=>'Fallback','kind'=>'none']) + ['id'=>1,'awarded_count'=>0];
check(Order_prize_rules::fallback($p), 'unlimited free fallback');
foreach (['cost'=>1,'stock'=>0,'threshold_spins'=>1,'threshold_revenue'=>1,'threshold_profit'=>1,'active'=>0,'auto_metric'=>'profit'] as $field=>$v) {
    check(!Order_prize_rules::fallback(array_merge($p,[$field=>$v])), 'fallback excludes '.$field);
}
$totals=['spin_count'=>1,'revenue_total'=>0,'profit_total'=>-100,'awarded_cost'=>100];
check(Order_prize_rules::eligible($p,$totals,10), 'fallback survives loss and exhausted budget');
check(!Order_prize_rules::eligible(array_merge($p,['stock'=>0]),$totals,null), 'stock exhausted');
check(!Order_prize_rules::eligible(array_merge($p,['active'=>0]),$totals,null), 'inactive');
$premium=array_merge($p,['kind'=>'physical','cost'=>100000,'auto_metric'=>'profit','allocation_percent'=>10,'stock'=>2,'threshold_spins'=>10]);
$totals=['spin_count'=>10,'revenue_total'=>2000000,'profit_total'=>999999,'awarded_cost'=>0];
check(!Order_prize_rules::eligible($premium,$totals,null),'below automatic gate');
$totals['profit_total']=1000000;
check(Order_prize_rules::eligible($premium,$totals,null),'exact gate unlock');
$premium['awarded_count']=1;
check(!Order_prize_rules::eligible($premium,$totals,null),'second unit cannot reuse gate');
$totals['profit_total']=2000000;
check(!Order_prize_rules::eligible($premium,$totals,null),'spin gate also recurring AND');
$totals['spin_count']=20;
check(Order_prize_rules::eligible($premium,$totals,null),'second unit next milestone');
$totals['awarded_cost']=100001;
check(!Order_prize_rules::eligible($premium,$totals,10),'aggregate budget across prizes');
$totals['awarded_cost']=100000;
check(Order_prize_rules::eligible($premium,$totals,10),'budget exact boundary');
$premium['auto_metric']='revenue'; $totals['profit_total']=-100; $totals['awarded_cost']=0;
check(Order_prize_rules::eligible($premium,$totals,null),'revenue auto independent of profit');
check(!Order_prize_rules::eligible($premium,$totals,10),'negative profit blocks paid prizes under budget');
$round=array_merge($p,['cost'=>1,'kind'=>'voucher','auto_metric'=>'profit','allocation_percent'=>3]);
$totals['profit_total']=33;
check(!Order_prize_rules::eligible($round,$totals,null),'ceil division not premature');
$totals['profit_total']=34;
check(Order_prize_rules::eligible($round,$totals,null),'ceil division boundary');
$pool=[['id'=>1,'weight'=>90],['id'=>2,'weight'=>9],['id'=>3,'weight'=>1]];
$distribution=[1=>0,2=>0,3=>0];
for ($i=1;$i<=100;$i++) $distribution[Order_prize_rules::draw($pool,$i)['id']]++;
check($distribution===[1=>90,2=>9,3=>1],'weighted draw every ticket boundary');
for ($i=0;$i<50;$i++) check(in_array(Order_prize_rules::draw($pool)['id'],[1,2,3],true),'CSPRNG draw membership');
rejects(function () { Order_prize_rules::draw([]); },'no eligible prize');
Order_prize_rules::transition('pending','claimed',['pending'=>['claimed']], 'claim');
check(true,'allowed transition');
Order_prize_rules::transition('claimed','claimed',[], 'claim');
check(true,'idempotent transition');
rejects(function () { Order_prize_rules::transition('sent','reserved',['sent'=>['delivered']], 'prize'); },'no reverse fulfillment');
echo "PASS: $count rules assertions\n";
