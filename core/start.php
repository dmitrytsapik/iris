<?php
/**
* Open School Journal
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
//Организация сессии 
session_start();
if($_GET['logout']) session_unset();
require_once('login.php');
/* Реализация мультиязычности приложения,
 * исходный взят с: http://alexmuz.ru/php-gettext/ */
$lang = 'ru';
$locale = "ru_RU.utf8";
$domain = 'messages';
$locale_path = '../locale';
putenv('LC_ALL='.$locale); putenv('LANG='.$locale); putenv('LANGUAGE='.$locale);
if (!setlocale (LC_ALL, $locale.'.utf8', $locale.'.utf-8', $locale.'.UTF8', $locale.'.UTF-8', $lang.'.utf-8', $lang.'.UTF-8', $lang)) setlocale(LC_ALL, '');
bindtextdomain($domain, $locale_path);
bind_textdomain_codeset($domain, 'UTF-8');
textdomain($domain);
require_once('mysql_connect.php'); //Подключение базы данных
/* Для того, чтобы подключить библиотеку, нужно создать файл /libs/*.lib.php
 * $libs_js_css - добавит ваш js или css в <head> страницы. */
if ($_GET['libs']!=='disabled') foreach (glob("libs/*.lib.php") as $filename) include_once($filename);
if(isset($_SESSION['access'])) {
foreach (glob("modules/*.mod.php") as $filename) include_once($filename);
$modules = glob("modules/*.mod.tpl");
}
//Стандартная шапка начало
require('/usr/share/php/smarty3/Smarty.class.php');
$smarty = new Smarty;
$smarty->force_compile = true;
//$smarty->debugging = true;
$smarty->caching = false;
$smarty->cache_lifetime = 1;
$smarty->template_dir = 'core/templates/';
$smarty->compile_dir = 'core/templates_c/';
$smarty->config_dir = 'core/configs/';
$smarty->cache_dir = 'core/cache/';
//Трюки с языками
$smarty->assign("title", HDR_TITLE);
$smarty->assign("libs", $libs_js_css);
$smarty->assign("exit",  _('Выйти'));
$smarty->assign("user", _('Пользователь'));
$smarty->assign("fill_lp", _('Введите логин и пароль!'));
$smarty->assign("not_ans", _('Нет ответа от сервера'));
$smarty->assign("inc_lp", _('Некорректный логин или пароль'));
$smarty->assign("login", _('логин'));
$smarty->assign("password", _('пароль'));
$smarty->assign("sign_up", _('Войти'));
$smarty->assign("panel", $panel);
$smarty->assign("body", $body);
$smarty->assign('modules', $modules);
$smarty->display('index.tpl');
?>