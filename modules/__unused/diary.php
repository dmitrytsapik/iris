<?php
$from=$_GET['from'];
$to=$_GET['to'];
$out.='<div style="margin-left:12px; margin-top:12px; margin-right:12px;">
<form style="float:left;" class="form-inline">
    <input id=data1 type="text" name="from" class="input-small" placeholder="с даты">
    <input id=data2 type="text" name="to" class="input-small" placeholder="по дату">
    <button type="submit" class="btn">Выбрать</button>
    <script>
	$("#data1").datepicker(); $("#data1").datepicker("option", "dateFormat", "yy-mm-dd");
	$("#data2").datepicker(); $("#data2").datepicker("option", "dateFormat", "yy-mm-dd");
    </script>
</form>
<div style="float:right">
    <a class="btn btn-primary" href="?header=disabled"><i class="icon-print icon-white"></i> Печать</a>
    <a class="btn btn-success" href="?logout=1"><i class="icon-print icon-white"></i> Печать табеля</a>
</div>
</div>';
$out.="\n<table style='float:left;' class='data table table-bordered'>
<tr>
<th style='width:20%'>".SUBJECT."</th>
<th>".THEME."</th>
<th>".HOMEWORK."</th>
<th style='width:12%'>"._DATE."</th>
<th style='width:5%'>".GRADE."</th>
</tr>\n";
$select_class=SQL_FA("select * from `classes` where `login`='".$_SESSION['login']."'");
$select_class=$select_class['class'];
if(isset($from) && isset($to)) {
$add = " and date BETWEEN '".$from."' AND '".$to."' ";
}
$query=SQL_RET("select * from `journals` where `class`='".$select_class."' ".$add." GROUP BY `date` order by `date` DESC"); $tdate=0;
if(!($query->rowCount())) $out.="<tr><td style='text-align:center; font-weight:bold' colspan='5'>Записей за этот период не найдено.</td></tr>\n";
while($user=ON_FA($query))
     {
     $out.="<tr><td style='text-align:center; font-weight:bold' colspan='5'>".date( 'l jS \of F Y', strtotime($user['date']))."</td></tr>\n";
     $dquery=SQL_RET("select * from `journals` where `class`='".$select_class."' and `date`='".$user['date']."' order by `order`");
     while($duser=ON_FA($dquery)) {
       if($draw_user)  { 
	 $draw_user_color=" style='background-color:rgb(221, 238, 255)'";
	 $draw_user=false;
	 }
	 else
	 {
	 $draw_user_color=NULL;
	 $draw_user=true;
	 };
     $grade=SQL_FA("select * from `grades` where `login`='".$_SESSION['login']."' and `subject`='".$duser['subject']."' and `date`='".$duser['date']."'");
     $out.="<tr$draw_user_color><td>".$duser['order'].". ".$duser['subject']."</td><td>".$duser['theme']."</td><td>".$duser['homework']."</td><td>".$duser['date']."</td><td>".(is_array($grade) ? $grade['grade'] : '&mdash;')."</td></tr>\n";
     }     
     }
$out.="</table>";
?>