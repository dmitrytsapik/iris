<?php
/**
* Open School Journal (Technical Preview)
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
// Check access rights
if(!($_SESSION['access']=='teacher')) { header("Location: /"); }
//Estimate pupil
if (isset($_POST['lesson'])) {
SQL_NOISE("Insert into `journals` values ('".$_SESSION['login']."','".$_POST['date']."','".$_POST['class']."','".$_POST['subject']."','".$_POST['theme']."','".$_POST['homework']."')");
header("Location: ?"); }

if (isset($_POST['estimate'])) {
SQL_NOISE("Insert into `grades` values ('".$_POST['estimate']."','".$_POST['date']."','".$_POST['class']."','".$_POST['subject']."','".$_POST['grade']."')");
header("Location: ?get=journal&class=".$_POST['class']."&date=".$_POST['date']."&subject=".$_POST['subject']."&system=us"); }
//
if ($_GET['get']=='journal') {
$query=SQL_RET("select * from `classes` where `class`='".$_GET['class']."'");
$tdate=0;
print '<script>
function grade($login, $class, $date, $subject) { 
$x = "#" + $login;
$.post("index.php", { estimate: $login, class: $class, date: $date, subject: $subject, grade: $($x).val()
},
function(data) { location.reload(); });
}
</script>
<table style="margin-top:30px" class="data table table-bordered"><th>'.NAME.'</th><th>'.GRADE.'</th>';
while($journal=ON_FA($query))
{
$journal1=SQL_FA("select * from `users` where `login`='".$journal['login']."' order by `name`");
$journal2=SQL_FA("select * from `grades` where `login`='".$journal['login']."' and `date`='".$_GET['date']."' and `subject`='".$_GET['subject']."'");
print "<tr><td>".$journal1['name']."</td><td>".grade_system($journal2['grade'], $journal['login'])."</td></tr>";
}
print '</table>';
die('<button style="margin-left:20px;" class="btn btn-success" onclick="location.reload();"><b>'.BACK.'</b></button>');
}
// Grade System US; GE; FR (or other).
function grade_system ($grade, $login) {
if (isset($grade)) { return $grade; };
$arrgrade = array('us', 'ge', 'fr');
if (!in_array($_GET['system'],$arrgrade)) { return "<b>Grades: Not available</b>"; }
include_once('./language/grade_systems.php');
if ($_GET['system']=='us') { $gradesys=$grade_us; }
if ($_GET['system']=='ge') { $gradesys=$grade_ge; }
if ($_GET['system']=='fr') { $gradesys=$grade_fr; }
$return.='<select id="'.$login.'">';
foreach ($gradesys as $value) { $return.='<option value="'.str_replace(" ", "", $value).'">'.$value.'</option>'; }
return $return.='</select><button onclick=grade("'.$login.'","'.$_GET['class'].'","'.$_GET['date'].'","'.$_GET['subject'].'")>'.WRT_DWN.'</button>';
}
// Print teacher's journal
$out.= "<div id='journal_tbl'><table class='data table table-bordered'>
	  <th>".SUBJECT."</th><th>".THEME."</th><th>".HOMEWORK."</th><th>"._DATE."</th><th>"._CLASS."</th>";
$query1=SQL_RET("select * from `journals` where `login`='".$_SESSION['login']."' order by `date` DESC");
$tdate=0;
while($journal1=ON_FA($query1))
     {
     if(!($tdate==$journal1['date']))
       {
       $out.= "<tr><td colspan='6'>".date( 'l jS \of F Y', strtotime($journal1['date']))."</td></tr>";
       $query=SQL_RET("select * from `journals` where `login`='".$_SESSION['login']."' and `date`='".$journal1['date']."' order by `date` DESC");
       while($journal=ON_FA($query))
       {
       $s=$journal['subject']; $th=$journal['theme']; $j=$journal['homework'];
       $d=$journal['date']; $c=$journal['class'];
       $out.= "<tr id='?get=journal&class=".$c."&date=".$d."&subject=".$s."&system=fr'>
       <td>".$s."</td><td>".$th."</td><td>".$j."</td><td>".$d."</td><td>".$c."</td></tr>";
       }
       }     
     $tdate=$journal1['date'];
     }
$out.="</table>
<button style=\"margin-left:20px;\" class=\"btn btn-success\" onclick='$(\"#dialog\").dialog(\"open\")'>";
$out.= ADD_NL.'</button>
<script>
$(document).ready(function() { $("#dialog").dialog( { resizable: false }, { width: "auto"}, { height: "auto"}, { autoOpen: false } );  });
function lesson() 
{
$.post(" ",
{
lesson: "true", class: $("#class").val(), date: $("#datepicker").val(), subject: $("#subject").val(), theme: $("#theme").val(), homework: $("#homework").val() },
function(data) { $("#page").html(data); });
}
$(function() {
$( "#datepicker" ).datepicker();
$( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd");
$("#journal_tbl tr").dblclick(function(){
var href = $(this).attr("id");
if (href !== undefined) {
$.get(href, function(data) { $("#page").html(data); });
}
});
$("#journal_tbl tr").mouseover(function() { $(this).addClass("info"); });
$("#journal_tbl tr").mouseout(function() { $(this).removeClass("info"); });
});
</script>
<div id="dialog" title="'.ADD_NL.'">
<input placeholder="'.SUBJECT.'" type="text" class="input-large" id="subject"><br>
<input placeholder="'.LESSON.'" type="text" class="input-large" id="lesson"><br>
<input placeholder="'.THEME.'" type="text" class="input-large" id="theme"><br>
<input placeholder="'.HOMEWORK.'" type="text" class="input-large" id="homework"><br>
<input placeholder="'._CLASS.'" type="text" class="input-large" id="class"><br>
<input class="input-large" placeholder="'._DATE.'" id="datepicker" type="text"><br>
<input type="submit" class="btn btn-success" onclick="lesson();" value="Create">
</div>';
?>