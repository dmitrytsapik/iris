<?php
error_reporting(E_ALL);
include_once('mysql_connect.php');
//$date = date("Y-m-d H:i:s");
$date='2013-02-01 07:40:00';
function check_interval($d1, $d2, $i) { $d1 = new DateTime($d1); $d2 = new DateTime($d2); $d1->modify($i." minutes"); return $d1>=$d2; }
$lessons=SQL_RET("SELECT * FROM journals where `status`!='canceled' and `status`!='done'");
while($lesson=ON_FA($lessons))
{
//time vars
$add=''; $st=$lesson['status']; 
$duration=SQL_FA("SELECT * FROM schedule WHERE num=".$lesson['order']);
$lastvis=SQL_FA("SELECT * FROM lastvis WHERE login='".$lesson['login']."'");
$time=$lesson['date'].' '.substr($duration['dur'],0,5);
//check teacher
if(check_interval($lastvis['place'], $time, '+30')) { $status='need_repl'; $desc='Sys.: Warning! N/A! Cancel after 20 min.!'; }
else { $status='ok'; $desc='OK!'; };
//status 'repl'
if($status=='need_repl') {
if(check_interval($date, $time, '+20') && $lesson['status']=='need_repl') {
$skill_s=SQL_RET("SELECT * FROM users where `type`='teacher' and `skill`='".$lesson['subject']."'");
while($skills=ON_FA($skill_s))
{
print 'kkk: '.$skills['login'];
}
}
if(check_interval($date, $time, '+10')) { $status='canceled'; $desc='System: Void. Canceled!'; $add=", `order`=8"; }
} elseif($status=='ok' && check_interval($date, $time, '0')) { $status='done'; };
SQL_NOISE("update `journals` set `desc`='".$desc."', `status`='".$status."'".$add."  where `order`='".$lesson['order']."' and `login`='".$lesson['login']."'
	  and `date`='".$lesson['date']."'");
print $time.' '.$lesson['login'].' '.$lesson['subject'].' '.$status.'<br>';
}
?>