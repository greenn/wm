<?#0.1.2

function mysql_create_db($dbName){

	$Mysql = mysql_i(); //получаем текущие соединение

	$sql = "CREATE DATABASE IF NOT EXISTS $dbName";

	$res = $Mysql->query($sql); //создаём базу данных

	//d_($sql, $res);

	if ($res) {
		$Mysql->select_db($dbName); //подключаемся к данной базе
	}
}