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
include ('config.php');
class Database
{
    function __construct($host, $database, $login, $password) {
	global $dbh;
	try {
	    $dbh = new PDO('mysql:host='.$host.';dbname='.$database, $login, $password);
	    } catch (PDOException $e) {
	      die("Error: " . $e->getMessage() . "<br/>");
	    }  
	    $dbh->query("SET NAMES 'utf8'");
    }
    function __destruct() {
        global $dbh;
        $dbh=null;
    }
    public function ReturnQuery($query) {
	global $dbh;
	return $dbh->query($query);
    }
    public function FetchAssoc($query) {
	return $this->ReturnQuery($query)->fetch(PDO::FETCH_ASSOC);
    }
    
}
$db = new Database($host, $database, $login, $password);
function SQL_FA($query) { global $db; return $db->FetchAssoc($query); }
function SQL_FN($query) { global $db; return SQL_RET($query)->fetch(PDO::FETCH_NUM); }
function SQL_NOISE($query) { SQL_RET($query); return 1; }
function SQL_RET($query) { global $db; return $db->ReturnQuery($query); }
function ON_FA($query) { return $query->fetch(PDO::FETCH_ASSOC); }
?>