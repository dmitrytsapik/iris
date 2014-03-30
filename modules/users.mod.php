<?php
/**
* Open School Journal (Technical Preview)
* Copyright (C) 2014 Dmitry Tsapik
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
$panel.='<li class="active">
            <a href="#users" onclick="$.get(\'modules/users.mod.php\', { page: \'true\' }).done(function(data) { $(\'#modules\').html(data); });$(\'#navigate li\').removeClass(\'active\');$(this).parent().addClass(\'active\');">
                <i class="icon-user"></i> '._("Пользователи").'
            </a>
        </li>
        <script>
        	$("#navigate a:eq(0)").click();
        </script>';
include_once('../core/login.php');
include_once('../core/mysql_connect.php');
//if(!(($_SESSION['access'])=='admin')) { header("Location: /"); die(); }
// Users table begin
if($_GET['get_users_by_type'])
    {
        if ($_GET['search'])
            {
                $p_search = "AND MATCH(users.name, users.surname) AGAINST('".$_GET['search']."' IN BOOLEAN MODE)";
            }
        die(json_encode(SQL_RET("SELECT users.name, users.surname, users.patronymic, users.login, users.birthday, groups.start_date, groups.end_date, groups.qualification, groups.caption FROM users LEFT JOIN pupils ON users.login=pupils.login LEFT JOIN groups ON groups.gid = pupils.group where users.type='".$_GET['get_users_by_type']."' ".$p_search." ORDER BY users.name")->fetchAll(PDO::FETCH_ASSOC)));
    }
$u_name=$_POST['name'];
$u_surname=$_POST['surname'];
$u_patronymic=$_POST['patronymic'];
$u_login=$_POST['login'];
$u_pass=$_POST['pass'];
$u_pass_hash=pass_hash($u_pass);
$u_access=$_POST['type']; 
$u_bday=$_POST['birthday'];
$u_descr=$_POST['other'];
$u_sign=$_POST['sign'];
$u_type=$_POST['type'];
switch ($_POST['user']) {
    case 'new':
        SQL_NOISE("Insert into `users` values ('$u_name', '$u_surname', '$u_patronymic', '$u_login', '$u_pass_hash', '$u_access', '$u_bday', '$u_descr')");
	die(_('Пользователь добавлен: ').$u_name);
        break;
    case 'edit':
        if($u_pass) SQL_NOISE("update `users` set `pass`='$u_pass_hash' where `login`='$u_sign'");
	SQL_NOISE("update `users` set `name`='$u_name', `login`='$u_login', `type`='$u_type', `birthday`='$u_bday', `other`='$u_descr'
	  where `login`='$u_sign'");
	die(_('Пользователь изменен: ').$u_name);
        break;
    case 'delete':
        SQL_NOISE("delete from `users` where `login`='$u_login'");
       	die(_('Пользователь удален: ').$u_login);
        break;
}
$a_caption=$_POST['caption'];
switch ($_POST['privileges']) {
    case 'new':
        SQL_NOISE("Insert into `access_level` values ('$a_caption', '".$_POST['levels']."')");
	die(_('Группа добавлена: ').$a_caption);
        break;
    case 'edit':
        if($u_pass) SQL_NOISE("update `users` set `pass`='$u_pass_hash' where `caption`='$u_sign'");
	SQL_NOISE("update `access_level` set `caption`='$a_caption', `levels`='".$_POST['levels']."'  where `caption`='".$_POST['caption_prev']."'");
	die(_('Группа изменена: ').$a_caption);
        break;
    case 'delete':
        SQL_NOISE("delete from `access_level` where `caption`='".$_POST['caption']."'");
       	die(_('Группа удалена: ').$a_caption);
        break;
}
$query=SQL_RET("select * from `access_level` order by `caption`");
while($user=ON_FA($query))
{
$groups_access.='<tr>
		<td class="priv_capt">
		      <input type="hidden" value="'.$user['caption'].'" ><input value="'.$user['caption'].'" class="input-medium" type="text" placeholder="'._("Название").'">
		   </td>
		   <td>
		      <input value="'.$user['levels'].'" class="input-medium" type="text" placeholder="'._("Доступ к модулям (через запятую,без пробелов)").'">
		   </td>
		   <td>
		      <button name="save_p" class="btn btn-mini btn-success">'._('Сохранить').'</button>
		      <button name="remove_p" class="btn btn-mini btn-danger">'._('Удалить').'</button>
		   </td>
		  </tr>';
$users_access.='<li><a onclick="$.cookie(\'user_access\', \''.$user['caption'].'\');$(\'#groups_nav li a\').css(\'color\', \'\');$(this).css(\'color\', \'red\');Users.MakeTable($.cookie(\'user_access\'));" href="#">'.$user['caption'].'</a></li>';
}
if($_GET['page']) { 
    include_once('smarty_for_mods.php');
    $smarty = new Smarty_Modules();
    $smarty->assign('groups_and_privileges', _('Группы'));
    $smarty->assign('new_user', _('Новый'));
    $smarty->assign('group', _('Группа'));
    $smarty->assign('privileges', _('Привилегии'));
    $smarty->assign('operations', _('Операции'));
    $smarty->assign('cancel', _('Отменить'));
    $smarty->assign('add_group', _('Добавить группу'));
    $smarty->assign('groups_access', $groups_access);
    $smarty->assign('users_table', $users_access);
    $smarty->display('users.mod.tpl');
    		  };
	   ?>