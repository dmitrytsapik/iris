{literal}
<style>
    body .modal-dialog { width: 95%; }
</style>
{/literal}
<script>
var edit_state="none";
var login="none";
var Users = {
	MakeTable: function(users_type, search_u) {
		var user_table;
		$.getJSON('modules/users.mod.php', { get_users_by_type: users_type, search: search_u })
			.done(function(data){
				data.forEach(function(entry){
					var temp;
					$.each(entry, function(ans, val){
						temp+='<td class="' + ans + '">' + val +"</td>"; });
					user_table+='<tr id="' + entry['login'] + '">' + temp + "</tr>";});
				$('tbody').html(user_table||"<tr><td style='text-align:center;' colspan=9>В этой группе пользователей нет</td></tr>");
				$("tr").dblclick(function(){
					var href = $(this).attr("id");
					if (href !== undefined){
						window.edit_state = "edit";
						window.login=href;
						$("#add_user_winLabel").html("Редактируемый пользователь");
						$("#add_user_win input:eq(14)").val(href);
						var user_inputs=[$(this).find("td.name").html(),
										 $(this).find("td.surname").html(),
										 $(this).find("td.patronymic").html(),
										 $(this).find("td.birthday").html()];
						for (var i = 0; i < 5; i++){
							$("#add_user_win input:eq(" + i + ")").val(user_inputs[i]);}
						//$("textarea[name=other]").val($(this).find("td.descr").html());
						$("#add_user_win").modal("show");}	});	});
		return false; }
};
function test_fill(){
	$.get("core/login.php", { login: $("input[name=login]").val() }, function(data) {
		if(data=="fail" && edit_state=="new") {
			alert("К сожалению, но данный логин уже занят!");
			$("input[name=login]").val("") }	});
	if($("input[name=name]").val() && $("input[name=login]").val()) {
		$("#save").removeAttr("disabled"); } else {
		$("#save").attr("disabled", true); }	}
{include file='users.prepare.tpl'}
$(document).ready(function() { 
	Users.MakeTable(function() { 
		if($.cookie("user_access")) { 
			return $.cookie("user_access");
			}
		else
			{ return "admin"; }
	});
	$("#datepicker").datepicker({ dateFormat: 'yy-mm-dd' });
		var options = { 
			beforeSubmit: function(arr, $form, options) { 
			return false                  
			}
		};
	$('#myForm').ajaxForm(options);
	$("#del_btn").click(function()
	{
		if(window.login=="admin") {
			alert("К сожалению, но главного администратора удалять нельзя!");
		} else
		{
			$.post("modules/users.mod.php", { user: "delete", login: window.login }, function(data) { alert(data);} );
		}
	Users.MakeTable($.cookie("user_access"));
	});
	$("#save").click(function(){
		$.post("modules/users.mod.php", ($('#myForm').serialize()+"&"+$.param({ user: edit_state, access: "admin", sign: login, type: $.cookie("user_access") })),
			function(data) { alert(data); } );
			Users.MakeTable($.cookie("user_access"));
			});
	});

$(document).keypress(function (e) { 
	if(e.shiftKey && e.which==70) $("#search").toggle();
});
</script>
<div class="pull-right" style="margin:3px;margin-top:-48px;margin-bottom:8px">
<a href="#access_window" style="margin:3px;" role="button" class="btn btn-sm btn-success pull-right" data-toggle="modal">
	<span class="glyphicon glyphicon-eye-close"></span>
	{$groups_and_privileges}
</a>
<a onclick="$('#add_user_winLabel span').html('Новый пользователь');edit_state='new';$('#myForm').clearForm();" href="#add_user_win" style="margin:3px;" data-toggle="modal" class="btn btn-sm btn-info pull-right">
	<span class="glyphicon glyphicon-user"></span>
	{$new_user}
</a>
</div>
<ol id=groups_nav class="breadcrumb unselectable">
{$users_table}
</ol>
{assign var="unsel" value='class="unselectable"'}
<table style="margin-top:-12px;font-size: 0.9em;" class="table-hover table table-bordered data">
      <thead>
	  <tr>
	      <th {$unsel} style="width:15%">Фамилия</th>
	      <th {$unsel} style="width:15%">Имя</th>
	      <th {$unsel} style="width:15%">Отчество</th>
	      <th {$unsel} style="width:5%">Логин</th>
	      <th {$unsel} style="width:6%">Дата рождения</th>
	      <th {$unsel} style="width:6%">Начало учебы</th>
	      <th {$unsel} style="width:6%">Окончание учебы</th>
	      <th {$unsel} style="width:6%">Квалификация</th>
	      <th {$unsel} style="width:12%">Статус</th>
	  </tr>
      </thead>
      <tbody>
      </tbody>
</table>
<form id="search" style="padding:8px;display:none" class="navbar-form navbar-right navbar-fixed-bottom navbar-inverse">
    <input onkeyup="Users.MakeTable($.cookie('user_access'), $('#search_u').val());" id=search_u type="text" style="width:30%" class="form-control" placeholder="Search">
</form>