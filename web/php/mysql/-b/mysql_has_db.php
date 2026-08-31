<?#0.1.4

//https://stackoverflow.com/questions/8829102/check-if-table-exists-without-using-select-from

function mysql_has_db($dbName){
	$Mysql = mysql_i(); //получаем текущие соединение

	//$sql = "SHOW TABLES LIKE '$dbName'";
	$sql = "SHOW DATABASES LIKE '$dbName';";

	$res = $Mysql->query($sql);

	$has_db = !!$res->num_rows;

	$res->close();

	return $has_db;
}