<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

//dx(pro::$cfg, mc::$mysql, mc);
//d(pro::cfg_get('db', 'user_name'), pro::cfg_get('db_name'));


$userName = pro::cfg_get('db', 'user_name');
$userPass = pro::cfg_get('db', 'user_pass');
$dbName = pro::cfg_get('db_name');
d($userName, $userPass, $dbName);


//db_host, user_name, user_pass, db_name
$mysqli = _mysql::connect(pro::cfg_get('db'));
if ($mysqli->ping()) {
	echo 'Соединение с базой данных установлено.';
} else {
	echo 'Произошла ошибка при установке соединения с базой данных.';
}
echo '<br /><br />';

//dx($mysqli);

if (true && 'v1') {
	$mysql = _mysql::connection(array($userName, $userPass));
	//dx($mysql->db->exist($dbName));
	//dx($mysql->db_exist($dbName));
	dx(mc::db_exist($dbName));
}

// Проверяем существование базы данных
$query = "SELECT SCHEMA_NAME FROM SCHEMATA WHERE SCHEMA_NAME = '$dbName'";
$result = $mysqli->query($query);

if ($result && $result->num_rows > 0) {
	echo 'База данных существует.';
} else {
	echo 'База данных не существует.';
}

