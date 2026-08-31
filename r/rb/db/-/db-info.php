<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

//d(pro::$cfg);
//d(pro::cfg_get('db'), pro::cfg_get('db_name'));


$dbName = mc::$mysql->db_name;
if (!mc::db_exist($dbName)) {
	echo "Базы <b>`$dbName`</b> не существует";
	exit;
}