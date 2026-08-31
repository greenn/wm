<?#0.2.3
//расширитель для mysql.class по работе с базами

class mysql_db {
	var $mysql;
	function __construct($Mysql) {
		$this->mysql = $Mysql;
	}

	function select($dbName){
		//dx('mysql_db/select', $dbName);
		$success = $this->mysql->instance->select_db($dbName);
			//https://www.php.net/manual/ru/mysqli.select-db.php
		//dx('mysql_db/select', $success, $this->mysql->error());
		if ($success) {
			$this->mysql->db_name = $dbName;
		}
		return $success;
	}

	function create($tableName, $useAfterCreate = true){
		$sql = "CREATE DATABASE IF NOT EXISTS `$tableName`";
		$res = $this->mysql->query($sql); //создаём базу данных
		//dx('mysql_db/create', $res, $sql);

		if ($res && $useAfterCreate) {
			$this->select($tableName); //подключаемся к данной базе
		}
		return $res;
	}

	function current($doRequest = true){
		$dbName = $this->mysql->db_name;
		//d($doRequest, $dbName);
		if ($doRequest) {
			$dbName = $this->mysql->query_r('SELECT DATABASE();');
		}
		return $dbName;
	}
	//01
	function current_is($verifyName, $doRequest = true){
		//$dbName = $this->mysql->current($doRequest);
		$dbName = $this->current($doRequest);
		return $verifyName ? $dbName === $dbName : $dbName;
	}

	function exist($dbName){
		return (boolean)$this->mysql->query_r("SHOW DATABASES LIKE '$dbName';");
	}
	function all(){
		return $this->mysql->query_rl('SHOW DATABASES;');
	}

}