<?php
/**
* Open School Journal (Technical Preview)
* Copyright (C) 2013  Dmitry Tsapik
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
include_once('mysql_connect.php');
session_start();
error_reporting(0);
function pass_hash($pass)
  {
  return md5(substr(crypt(crypt($pass, '$1$p@ssW0RDh@sh$'), '$6$'), 4));
  }
if($_POST['action'])
  {
  if(!$_POST['login'] && !$_POST['pass']) die();
  $access=SQL_FA("select * from `users` where `login`='".$_POST['login']."' and `pass`='".pass_hash($_POST['pass'])."'");
  if(is_array($access)) {
  $_SESSION['access']=$access['type'];
  $_SESSION['login']=$access['login'];
  $_SESSION['name']=$access['name'];
  die("1");
  } else { die("0"); }
  }
if (isset($_GET['login'])) {
$tmp2=SQL_FA("select * from `users` where `login`='".$_GET['login']."'");
echo strlen($tmp2['login'])==0 ? 'ok' : 'fail';
}
?>