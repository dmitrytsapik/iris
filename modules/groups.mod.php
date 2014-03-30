<?php
/**
* Open School Journalreview)
* Copyright (C) 2014  Dmitry Tsapik
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
error_reporting(E_ALL);
session_start();
header('Content-Type: text/html; charset=utf-8');
include_once('../core/mysql_connect.php');// Check access rights
//Добавление кнопки на панель
$panel.='<li>
			<a href="#groups" onclick="$.get(\'modules/groups.mod.php\', { page: \'true\' }).done(function(data) { $(\'#modules\').html(data); });$(\'#navigate li\').removeClass(\'active\');$(this).parent().addClass(\'active\');">
				<i class="icon-book"></i> '._("Группы").'
			</a>
		</li>';
//Вывод группы, согласно ид
if ($_GET['group']) {
die(json_encode(SQL_RET("SELECT * FROM pupils LEFT JOIN users ON users.login=pupils.login where pupils.group='".$_GET['group']."' order by users.name")->fetchAll(PDO::FETCH_ASSOC)));
}
//Вывод всех групп
$group_list=SQL_RET("SELECT t.*, count( DISTINCT m.login ) AS counter FROM groups t LEFT JOIN pupils m ON m.group = t.gid GROUP BY t.caption ORDER BY t.caption")->fetchAll(PDO::FETCH_ASSOC);
//Список действий
switch ($_POST['act']) {
    //Добавление новой группы
    case 'remove_group':
		SQL_NOISE("delete from `groups` where `gid`='".$_POST['gid']."'");
		die(_('Удалено ').$_POST['gid']);
    break;
    case 'remove_pupil':
    	SQL_NOISE("delete from `pupils` where `uniq_id`='".$_POST['uniq_id']."'");
    	die(_('Удалено ').$_POST['gid']);
    break;
    case 'new_group':
        SQL_NOISE("INSERT INTO `groups` VALUES (UNIX_TIMESTAMP(),
						'".$_POST['group_abbr']."',
						'".$_SESSION['login']."',
						'".$_POST['start_date']."',
						'".$_POST['end_date']."',
						'".date("Y-m-d")."',
						'".$_POST['spec']."',
						'".$_POST['qualification']."',
						'".$_POST['foe']."',
						'".$_POST['group_comment']."');");
		die(_('Успешно добавлен курс: ').$_POST['group_abbr']);
	break;
	//Добавление студента в группу
	case 'add_student':
		$students = explode(",", $_POST['login']);
		$sql = array();
    	foreach($students as $student) {
        	$sql[] = '("'.(time()+rand(1, 1000)).'", "'.mysql_real_escape_string($student).'", "'.$_POST['group'].'")';
    	}
        SQL_NOISE("INSERT INTO `pupils` VALUES ".implode(',', $sql));
     	die(_('Успешно добавлен студент/ы!'));
    break;
}
//Тут будет что-то переделано :)
if(!isset($libs_js_css)) {
include_once('smarty_for_mods.php');
$smarty = new Smarty_Modules();
$smarty->assign('lang', array('caption'=>_('Шифр'),
				'author'=>_('Создатель'),
				'name' => array('n'=>_('Имя'),
								's'=>_('Фамилия'),
								'p'=>_('Отчество'),
								'l'=>_('Логин'),
								'b'=>_('День рождения')),
				
				'load_bd_stud'=>_('Загружаю базу данных группы'),
				'delete'=>_('Удалить'),
				'group_is_empty'=>_('Пользователей в группе нет'),
				'period'=>_('Существование'),
				'date'=>_('Регистрация'),
				'qualification'=>_('Квалиф.'),
				'spec'=>_('Специал.'),
				'foe'=>_('Форма'),
				'foef'=>_('Форма обучения'),
				'comment'=>_('Комментарий'),
				'start'=>_('Начало'),
				'edit'=>_('Редактирование'),
				'end'=>_('Окончание'),
				'summary'=>_('&#931;'),
				'grouping'=>_('Группировка'),
				'new_group'=>_('Новая группа'),
				'add_student'=>_('Добавить студента'),
				'dialog_button'=>_('Добавить группу'),
				'dialog_group_abbr'=>_('Шифр группы (класса)'),
				'dialog_group_comment'=>_('Описание группы (класса)')));
$smarty->assign('group_list', $group_list);
$smarty->display('groups.mod.tpl');
}
?>