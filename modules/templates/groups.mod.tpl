{*
Задания для реализации:
1. Добавить редактировать группы
2. Добавить удаление пользователя
3. Включить список документов и чекбоксы для выбора на печать
4. Рендер этого шаблона на js и хранение в локальном хранилище
*}
{* Кнопки управления группами и студентами *}
<div id="group_buttons" class="pull-right" style="margin:3px;margin-top:-48px;margin-bottom:8px">
	{* Добавить группу *}
	<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#window">
		<span class="glyphicon glyphicon-inbox"></span> {$lang.dialog_button}
	</button>
	{* Добавить студента *}
	<button style="display:none" class="btn btn-sm btn-info" data-toggle="modal" data-target="#add_student_window">
		<span class="glyphicon glyphicon-user"></span> {$lang.add_student}
	</button>
</div>
<script>
	//Тут находятся div с заготовками диалогов
	{include file='groups.prepare.tpl'}
	/*
	$(window).bind('hashchange', function(e) {
   		var URL = $(location).attr('href');
        alert("Current URL Using JQuery : " + URL);
	});*/ 
	$(document).ready(function() { 
    	//Календарики
    	$('.datepicker').each(function() {
        	$(this).datepicker({ dateFormat: 'yy-mm-dd' });
    	});
    	//Инит формы для добавления группы
    	function showResponse(responseText, statusText, xhr, $form)	{ 
	    	alert(responseText); 
		}
    	var form_group = {
    	success: showResponse
    	} 
    	$('#group_add').ajaxForm(form_group);
    	$('#add_student_form').ajaxForm(form_group);
    });
	$("tr").dblclick(function() {
		var gid = $(this).attr("id");
		$('#add_student_form input[name=group]').val(gid);
		var table_data="";
		if (gid) {
		//Включение индикатора, скрытие кнопки добавления группы, отображение кнопки добавления студента
		$('#indicator, #group_buttons button:eq(0), #group_buttons button:eq(1)').toggle();
		//Вывод на экран списка студентов
		$.getJSON('modules/groups.mod.php', { group: gid }).done(function(data) {
		data.forEach(function(entry) {
		table_data+="<tr>";
		table_data+="<td>" + entry['name'] + "</td><td>" + entry['surname'] + "</td><td>" + entry['patronymic'] + "</td><td>" + entry['login'] + "</td><td>" + entry['birthday'] + "</td><td><button onclick='$.post(\"modules/groups.mod.php\", { act: \"remove_pupil\", uniq_id: "+ entry['uniq_id'] +" }).done(function( data ) { alert(data); });' class=\"btn btn-danger btn-xs\">{$lang.delete}</button></td>";
		table_data+="</tr>";
		}); 
		//Манипуляция с таблицей
		$('table thead').html("<tr><th>{$lang.name.s}</th><th>{$lang.name.n}</th><th>{$lang.name.p}</th><th>{$lang.name.l}</th><th>{$lang.name.b}</th><th>{$lang.edit}</th><tr>");
		$('table tbody').html(table_data);
		if(!$('table tbody').html()) { $('table tbody').html('<tr style="text-align:center"><td colspan=5>{$lang.group_is_empty}</td></tr>') }
		$('#indicator').hide();
		});
		}
	});
</script>
<!--Индикатор загрузки данных о группе-->
<div style="display:none" id="indicator">
	<div id="loader" class="progress progress-striped active">
		<div class="progress-bar"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
		  	<span>{$lang.load_bd_stud}</span>
		</div>
	</div>
	<style>
	   	#loader {
	    	position: fixed;
			height:30px;
			width:400px;
			right: 20px;
			bottom: 2px;
			background: #ffe; 
			text-align: center;
			vertical-align: middle;
			line-height: 30px;
	    }
	</style>
</div>
<!--Таблица для вывода групп, списка групп-->
<table style="font-size: 0.9em;" class="table table-bordered table-hover">
    <thead>
		<tr>
			{assign var=th_nms value=['caption', 'summary', 'spec', 'qualification', 'foe', 'start', 'end', 'date', 'comment', 'edit']}
		    {foreach from=$th_nms item=i}
			<th>{$lang.$i}</th>
			{/foreach}
	    </tr>
    </thead>
    <tbody>
	    {foreach from=$group_list item=i}
		<tr id="{$i.gid}">
			{assign var=td_nms value=['caption', 'counter', 'spec', 'qualification', 'foe', 'start_date', 'end_date']}
		    {foreach from=$td_nms item=a}
			<td>{$i.$a}</td>
			{/foreach}
		    <td>{$i.admin} : {$i.reg_date}</td>
		    <td>{$i.comment}</td>
		    <td>
				<button onclick='$.post("modules/groups.mod.php", { act: "remove_group", gid: "{$i.gid}" }).done(function( data ) { alert(data); });' class="btn btn-danger btn-xs">
				{$lang.delete}</button>
		    	<!-- Тут нужно сделать окно и подключить кнопку
		    	<button class="btn btn-info btn-xs">Ред.</button>-->
		    </td>
		</tr>
	    {/foreach}
    </tbody>
</table>
<p><b>Подсказка:</b><i> Для просмотра списка студентов в группе нажмите дважды по названию группы</i></p>