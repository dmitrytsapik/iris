// <script>
//var start = new Date();
// объект для подготовки страницы
//var end = new Date();
//alert('Скорость ' + (end.getTime()-start.getTime()) + ' мс');

var Users = {
	init: function(){
    
    $("#privileges tr td button[name='save_p']").click(function(){
	path = $(this).parents().parents();
	path1 = path.children("td:first");
	path2 = path.children("td:eq(1)");
	prev_priv = path1.children("input[type='hidden']").val();
	priv = path1.children("input[type='text']").val();
	levels_u = path2.children("input").val();
	if(!prev_priv) {
	    $.post("modules/users.mod.php", { privileges: "new", caption: priv, levels: levels_u }, function(data) { alert(data);});
	    } else {
		$.post("modules/users.mod.php", { privileges: "edit", caption_prev: prev_priv, caption: priv, levels: levels_u }, function(data) { alert(data);});
	    }
	$("#access_window").modal("hide");
	});
    $("#privileges tr td button[name='remove_p']").click(function(){ 
	path = $(this).parents().parents();
	path1 = path.children("td:first");
	prev_priv = path1.children("input[type='hidden']").val();
	if(prev_priv) $.post("modules/users.mod.php", { privileges: "delete", caption: prev_priv }, function(data) { alert(data);});
	$("#access_window").modal("hide");
	$.get('modules/users.mod.php', { page: 'true' }).done(function(data) { $('#modules').html(data); });
	});
	},
};
{strip}
{literal}
*/
$("#add_group").click(function(){
	$("#privileges > tbody:last").append("<tr><td class='priv_capt'><input type='hidden'><input class='input-medium' type='text' placeholder='Название'></td><td><input class='input-medium' type='text' placeholder='Доступ к модулям (через запятую,без пробелов)'></td><td><button name='save_p' class='btn btn-mini btn-success'>Сохранить</button> <button name='remove_p' class='btn btn-mini btn-danger'>Удалить</button></td></tr>");	
	init_p();
	});