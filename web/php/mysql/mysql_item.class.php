<?#0.6.7
//расширитель для mysql.class по работе с записями

class mysql_item {


	var $mysql;
	function __construct($Mysql) {
		$this->mysql = $Mysql;
	}

	protected $table_fields = array(); //cache структур mysql таблиц
	function get_fields($tbName, $fieldsOrder = false){
		if (!isset($this->table_fields[$tbName])) {
			$data = $this->mysql->query_rd("DESCRIBE `$tbName`;");
			$this->table_fields[$tbName] = $data;
		}
		$res = $this->table_fields[$tbName];
		if ($fieldsOrder) {
			$fields = array();
			foreach ($res as $info) {
				$fields []= $info['Field'];
			}
			$res = $fields;
		}
		return $res;
	}


	function has($tbName, $where) {
		return $this->mysql->count($tbName, $where) !== 0;
	}

	function get_all($table, $where, $order = false){
		return $this->get('*', $table, $where, $order);
	}

	function get($props, $table, $where, $order = false){

		$_props = array();
		foreach ((array)$props as $prop) {
			$_props []= $prop === '*' ? $prop : "`$prop`";
		}
		$props = join(', ', $_props);
		//d($props);
		$sql = _mysql::sql("SELECT $props FROM `%s`", $table, $where, $order);
		return $this->mysql->query_rd($sql);
		//return $this->mysql->query_rl($sql);
		//return $this->mysql->query_r($sql);
	}

	function get1($props, $table, $where){
		$res = $this->get($props, $table, $where);
		return $res ? $res[0] : null;
	}
	function get1_all($table, $where){
		return $this->get1('*', $table, $where);
	}
	function get1_prop($prop, $table, $where){
		$res = $this->get1($prop, $table, $where);
		return $res ? $res[$prop] : false;
	}

		/*
		    oo
			function has($table, $where, $order = false){
				$res = $this->get1_all($table, $where, $order);
				dx($res);
				return $res ? $res[$prop] : false;
			}
		*/


	function all($tbName, $order = false) {
		return $this->get_all($tbName, false, $order);
	}


	function update($table, $data, $where){
		$sql = _mysql::sql_set('UPDATE `%s`', $data);
		$sql = _mysql::sql($sql, $table, $where);
		return $this->mysql->query($sql);
	}

	function add($table, $data){
		$_props = array();
		$_values = array();
		foreach ($data as $prop => $value) {
			$_props []= "`$prop`";
			if (is_array($value)) {
				//case: специальная вставка
				if ($const = prop($value, 'const')) {
					$_values []= "$const";
				} else {
					dx('нужна обработка значения (isOrdinal) $value', $value);
				}
			} else {
				_mysql::_escapeValue($value);
				$_values []= "'$value'";
			}

		}
		$_props = join(', ', $_props);
		$_values = join(', ', $_values);

		$sql = "INSERT INTO `$table` ($_props) VALUES ($_values);";
		//dx($sql, $_props, $_values);
		$res = $this->mysql->query($sql);
		//d($sql, $res, $this->mysql->error(), $this->mysql->instance->insert_id);
		if ($res) {
			$res = $this->mysql->instance->insert_id;
			if (!$res) { //таблица без AUTO_INCREMENT
				$res = true;
			}
		}
		//slog('mysql/item/add', "новая запись в '$table'", array('new-id' => $res, 'error' => $this->mysql->error(), 'data' => $data, 'sql' => $sql));
		return $res;
	}

	//dd LIMIT
	function delete($table, $where){
		$sql = _mysql::sql_where("DELETE FROM `$table`", $where);
		$res = $this->mysql->query($sql);
		//$this->mysql->instance->affected_rows /~ak: 1
		//dx($sql, $res, $this->mysql->error(), $this->mysql->instance->affected_rows);
		return $res ? $this->mysql->instance->affected_rows : null;
	}

	/*
	join
		https://dba.stackexchange.com/questions/165642/how-does-left-join-with-where-clause-works
		https://stackoverflow.com/questions/20794425/php-mysql-join-statement
	*/


	function pickFields($table, $data, $except = array()){
		//d($table, $data, $except);
		$res = array();
		if ($data) {
			$struct = $this->get_fields($table, true);
			foreach ($struct as $name) {
				if (array_key_exists($name, $data)) {
					if (!in_array($name, $except)) {
						$res[$name] = $data[$name];
					}
				}
			}
		}
		return $res;
	}

}