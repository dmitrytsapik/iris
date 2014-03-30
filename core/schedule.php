<?php
/**
* Open School Journalreview)
* Copyright (C) 2012  Dmitry Tsapik
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version. 
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see http://www.gnu.org/licenses/.
**/
//if(!($_SESSION['access']=='teacher')) { header("Location: /"); }
//include_once('mysql_connect.php');
if($_GET['monday'] && $_GET['class']) {
$monday=date('Y-m-d', strtotime("Monday this week", strtotime($_GET['monday']))); // Начало недели
$sunday=date('Y-m-d', strtotime("Sunday this week", strtotime($monday))); // Начало недели
$out.="\n<table cols=9 class='data table table-bordered table-hover'>
<tr>
<th class='input-mini'>Урок</th>
<th>Время</th>";
$rStart = new datetime($monday);
$rStop = new datetime($monday);
for ($rStart; $rStart<$rStop; $rStart->modify('+1 day')) {
$date=$rStart;
$monday=$date->modify('Monday this week')->format('Y-m-d');
$sunday=$date->modify('Sunday this week')->format('Y-m-d');
$num_of_week=$date->format('W');
$out.= "<tr><td style='text-align:right;'>$i</td>
<td style='text-align:center;'>$monday</td>
<td style='text-align:center;'>$sunday</td><td>$num_of_week</td></tr>";
}
$out.="<th>"._('Monday')."</th>
<th>Вторник</th>
<th>Среда</th>
<th>Четверг</th>
<th>Пятница</th>
<th>Суббота</th>
<th>Воскресение</th>
</tr>";
/*
$query1=SQL_RET("select * from `journals` where class='".$_GET['class']."' and date between '$monday' and '$sunday' group by `date`, `order`");
while($journal1=ON_FA($query1))
{
$date=$journal1['date'];
$out.=$date!==$temp?'<tr><td style="text-align:center; font-weight:bold">'.date( 'l jS \of F Y', strtotime($date)).'</td></tr>':''; // get TRUE
$s=$journal1['subject'];
$l=$journal1['login'];
$d=$journal1['desc'];
$st=$journal1['status'];
$repl=$journal1['replace'];
$order=$journal1['order'];
$duration=SQL_FA("SELECT * FROM schedule WHERE num=".$order);
$teacher_name=SQL_FA("SELECT * FROM users WHERE login='".$l."'");
$dur=$duration['dur'];
$out.= "<tr".($st=='done'?' class="success"':($st=='canceled'?' class="error"':''));
$out.= '><td><select class="input-mini">';
$duration=SQL_RET("SELECT * FROM schedule");
while($dur1=ON_FA($duration))
{
$out.='<option'.(($order==$dur1['num'])?' selected=selected':'').'>'.$dur1['num']."</option>";
}
$out.= "</select>
<td>$dur</td>
<td>$s=".$teacher_name['name'].(!empty($repl)?' &rarr; '.$repl:'')."=$d=$st</td>
</tr>";
$temp=$date;
}*/
$out.="\n".'</table><script>
$(document).ready(function() { $("#dialog").dialog( { resizable: false }, { width: "auto"}, { height: "auto"}, { autoOpen: false } );  });
$("#journal_tbl tr").dblclick(function(){
var href = $(this).attr("id");
if (href !== undefined) {
$.get(href, function(data) { $("body").html(data); });
}
});
</script>';
}
else
{
$out.='<div style="text-align: center;"><h3>Учебная нагрузка</h3></div>';
$datetime1 = date_create('2009-10-11');
$datetime2 = date_create('2009-12-13');
$interval = date_diff($datetime1, $datetime2);
$days=$interval->days;
//Функция выводит недели с датами понедельников и воскресений 
$i=0;
function print_weeks_by_date($start_date, $end_date) {
$rStart = new datetime($start_date);
$rStop = new datetime($end_date);
for ($rStart; $rStart<$rStop; $rStart/*->modify('+1 week')*/) {
$i=++$GLOBALS['i'];
$date=$rStart;
$monday=$date->modify('Monday this week')->format('Y-m-d');
$sunday=$date->modify('Sunday this week')->format('Y-m-d');
$num_of_week=$date->format('W');
$return.= "<tr><td style='text-align:right;'>$i</td>
<td style='text-align:center;'>$monday</td>
<td style='text-align:center;'>$sunday</td><td>$num_of_week</td></tr>";
}
return $return;
}
$out.="<table class='data table table-bordered'>
<tr>
<th style='width:3%' class='input-mini'>#</th>
<th style='width:18%; text-align:center;'>Понедельник недели</th>
<th style='width:18%; text-align:center;'>Воскресенье недели</th>
<th style='width:18%'>Порядковый в году</th>
</tr>";
$query1=SQL_RET("select * from `plan` order by `monday`");
while($semester=ON_FA($query1))
{
$out.="<tr>
<td style=\"text-align:center; font-weight:bold\" colspan=5>".$semester['caption']."</td>
</tr>".print_weeks_by_date($semester['monday'], $semester['sunday']);
}
$out.="</table>";
}
?>