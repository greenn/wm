<?#0.4.500
/*


	https://dev.mysql.com/doc/refman/8.0/en/select.html
	https://dev.mysql.com/doc/refman/8.0/en/expressions.html
	https://www.tutorialspoint.com/mysql/mysql-where-clause.htm

	передаём на управление mysqli соединение

	eg
		$total = $db->count('news');
		$rows = $db->get_all('news', array('state' => 'on'), '`NID` DESC');
*/

_needphp(
	'mysql/mysql_db.class',
	'mysql/mysql_table.class',
	'mysql/mysql_item.class',
	'str/startsWith',
	'_str.class'
);

class mysql {
	var $instance; //instanceof mysqli
	var $db_name = false;
	var $db = false; //mysql_db{}
	var $table = false; //mysql_table{}
	var $item = false; //mysql_item{}

	function __construct($config) {
		$this->instance = _mysql::connect($config);
		$this->db = new mysql_db($this);
		$this->table = new mysql_table($this);
		$this->item = new mysql_item($this);
		$this->db_name = $this->db->current();
		//d($config, $this->instance, $this->db, $this->table, $this->item, $this->db_name);
	}

	private function transit($type, $name, $args_ = array()){
		$_map = array(
			'db_' => $this->db,
			'table_' => $this->table,
			'item_' => $this->item,
		);

		$_transit = false;
		$_name = false;
		foreach ($_map as $prefix => $object) {
			if (startsWith($name, $prefix)) {
				$_transit = $object;
				$_name = _str::raw_cut($name, $prefix);
				break;
			}
		}


		if ($_transit) {
			switch ($type) {
				case 'property-get': return $_transit->{$_name};
				case 'property-set': $value = $args_; return $_transit->{$_name} = $value;
				case 'method': return call_user_func_array(array($_transit, $_name), $args_);
			}
		} else {
			d('Wrong MC call', $_transit, $type, $name, $args_);
			//return call_user_func_array("static::$name", $args_);
		}

	}

	function __get($prop) {
		return $this->transit('property-get', $prop);
	}

	function __set($prop, $value) {
		return $this->transit('property-set', $prop, $value);
	}

	function __call($method, $args_){
		return $this->transit('method', $method, $args_);
	}

//= mysql operations
	//return: https://www.php.net/manual/ru/class.mysqli-result.php
	var $sql_log = array();
	function last_sql($rightIndex = 0){
		$index = count($this->sql_log) - 1 - $rightIndex;
		return isset($this->sql_log[$index]) ? $this->sql_log[$index] : null;
	}

	function query($sql){
		$this->custom_error = null;
		if (is_array($sql)) $sql = join(' ', $sql);
		$this->sql_log []= $sql;
		$mysql = $this->instance;
		$response = $mysql->query($sql);
		return $response;
	}

	private $custom_error = null;
	function set_error($msg){
		$this->custom_error = $msg;
		return null;
	}

	function error($native = false){
		$mysql = $this->instance;
		$error = $mysql->error;
		if (!$error && !$native) {
			$error = $this->custom_error ? '@: last_sql'.$this->custom_error : false;
		}
		return $error;
	}

	function query_rd($sql){ //result data
		$query = $sql instanceof mysqli_result ? $sql : $this->query($sql);
		$res = null;
		if ($query) {
			$res = array();
			while ($row = $query->fetch_assoc()){
				$res[] = $row;
			}
		}
		return $res;
	}

	function query_r($sql, $index = 0){ //r: result row - строка результата, хорошо подходит например для COUNT
		$query = $sql instanceof mysqli_result ? $sql : $this->query($sql);
		//иногда* $query может быть boolean *при ошибках или [mb] специфических запросах или ошибках
		if (is_bool($query)) {
			return $query;
		}
		$res = $query->fetch_row();
		return $res[$index];
	}

	//ak query_rd with fetch_row
	function query_rl($sql){ //result list
		$query = $sql instanceof mysqli_result ? $sql : $this->query($sql);
		//d($query, $sql, $query->fetch_all(), _mysql::fetch_all($query));
		//d($query, $sql, _mysql::fetch_all($query), $query->fetch_all());

		//return $query->fetch_all();
		return _mysql::fetch_all($query);
	}



//= record common operations
	function count($tableName, $conds = false){
		$result = false;
		$sql = "SELECT COUNT(*) FROM `%s`";
		$sql = _mysql::sql($sql, $tableName, $conds);

		$response = $this->query($sql);
		if ($response) {
			$data = $response->fetch_array();
			$result = (integer) $data[0];
		}

		return $result;
	}


	
	function all_data(){
		$data = array();
		$tables = $this->table->all();
		foreach ($tables as $tbName) {
			$data[$tbName] = $this->item->all($tbName);
		}
		return $data;
	}

	/*function get_all($tableName, $conds = false, $order = false){
		$sql = "SELECT * FROM `%s`";

		//_mysql::sql_conds($sql, $conds);
		//_mysql::sql_order($sql, $order);
		//$sql = sprintf($sql, $tableName);
		$sql = _mysql::sql($sql, $tableName, $conds, $order);
		//dx($sql);

		$data = array();
		$response = $this->query($sql);
		//dx($sql, $response);
		if ($response) while($row = $response->fetch_assoc()) {
			$data[] = $row;
		}
		//dx($data);

		return $data;

	}*/

}