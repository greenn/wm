<?#2.0.21


_needphp(
	'mysql/mysql.class',
	'isAssoc', 'isOrdinal'
);

class _mysql {
	static $connection;
	static $connection_config;
	//static $connection_config = array();
	static $connection_ordinal_decrypt = array('user_name', 'user_pass', 'db_name', 'db_host', 'db_port', 'db_socket');

	//получение объекта доступа к базе данных (mysql)
	static function connection($data, $decrypt = true){
		static::$connection_config = static::connect_config($data, $decrypt);
		//static::$connection = static::connect(static::$connection_config);

		static::$connection = new mysql(static::$connection_config);
		return static::$connection;
	}

	//получение информации (массив) об ошибке в mysql-исполнении
	public static function error($Mysql){
		$res = false;
		if ($Mysql instanceof mysqli && $Mysql->connect_errno) {
			$res = array($Mysql->connect_error, $Mysql->connect_errno);
		}
		return $res;
	}

	//подключение к mysql
	//получение instance mysqli-подключения
	public static function connect($config){
		//dx($config);
		$args = array(
			prop($config, 'db_host', 'localhost'),
			$config['user_name'],
			$config['user_pass'],
		);
		if (has_prop($config, 'db_name')) $args []= $config['db_name'];
		///else $args []= 'web-vmk'; //dbg
		//d($config);

		//ini_get("mysqli.default_port"), ini_get("mysqli.default_socket")
		//if (has_prop($config, 'db_port')) $args []= $config['db_port'];
		//if (has_prop($config, 'db_socket')) $args []= $config['db_socket'];

		//dx($args);
		////SET NAMES 'utf8mb4';

		$Mysql = call_user_func_array('mysqli_connect', $args);
		//dx(mysqli_get_server_info($Mysql)); //версия MySql
		//$class = new ReflectionClass('mysqli');
		//$Mysql = $class->newInstanceArgs($args);

		mysqli_set_charset($Mysql, "utf8mb4");

		//dx($args, $Mysql ? 'Успешно соединились' : 'Ошибка соединения: ', mysqli_connect_error());
		//dx($config, $args, $Mysql);

		return $Mysql;
	}

	//составление конифигурационного массива для подключения к mysql
	public static function connect_config($data, $decrypt = true){
		$config = array();
		if ($decrypt === true) $decrypt = static::$connection_ordinal_decrypt;
		if (isOrdinal($data)) {
			foreach ($data as $index => $value) {
				$prop = $decrypt[$index];
				$config[$prop] = $value;
			}
		} elseif (isAssoc($data)) { 
			foreach ($data as $prop => $value) {
				$config[$prop] = $value;
			}
		}
		return $config;
	}

		//dd-j проверят(сопоставляет) текущие соединение
		public static function verify($instance = true){
			if ($instance === true) $instance = static::$connection;
		}


	public static function escapeValue($value){
		$escapeWith = static::$connection->instance;

		if (is_string($value)) {
			$value = mysqli_real_escape_string($escapeWith, $value);
		} else if (isAssoc($value)) {
			foreach ($value as $name => $data) {
				$value[$name] = static::escapeValue($data);
			}
		}
		return $value;
	}

	public static function _escapeValue(&$value){
		$value = static::escapeValue($value);
	}



	//формирует sql строку с WHERE и ORDER
	public static function sql($sql_pattern, $sql_ctx, $conds = false, $order = false){
		//dx($sql_pattern, $sql_ctx, $conds, $order);
		$sql_pattern = _mysql::sql_where($sql_pattern, $conds);
		$sql_pattern = _mysql::sql_order($sql_pattern, $order);
		$sql_ctx = (array) $sql_ctx;
		array_unshift($sql_ctx, $sql_pattern);
		if (count($sql_ctx) === 2) {
			$sql = str_replace('%s', $sql_ctx[1], $sql_ctx[0]);
		} else {
			//dx($sql_ctx);
			$sql = call_user_func_array('sprintf', $sql_ctx);
		}
		return $sql;
	}

	public static function sql_set($sql, $data){
		if (isAssoc($data)) {
			$_data = array();
			foreach ($data as $name => $value) {
				static::_escapeValue($value);
				$_data []= "`$name` = '$value'";
			}
			$data = $_data;
		}
		if (is_array($data)) {
			$data = join(", ", $data);
		}
		if (is_string($data)) {
			$sql .= " SET $data";
		}

		return $sql;
	}

	//добавляет в текущий sql - WHERE услвовия
	public static function sql_where($sql, $conds){
		//dx($sql, $conds);
		if ($conds) {
			if (isAssoc($conds)) {
				$_conds = array();
				foreach ($conds as $name => $value) {
					$operator = '=';
					if (is_array($value)) {
						list($operator, $value) = $value;
					}
					static::_escapeValue($value);
					$_conds []= "`$name` $operator '$value'";
				}
				$conds = $_conds;
			}
			if (is_array($conds)) {
				$term = 'AND';
				//if (!starts_with array('OR', '||', 'XOR', 'AND', '&&',   'NOT', '!'))
				$conds = join(" $term ", $conds);
				//dx($conds);
			}
			if (is_string($conds)) {
				$sql .= " WHERE $conds";
			}
		}
		return $sql;
	}

	//добавляет в текущий sql - ORDER услвовия
	//ASC - по убыванию, DESC - по возрастанию
	//eg '`Category_ID`' //ASC по умолчанию
	//eg '`Category_ID` DESC'
	//eg array('Category_ID', 'DESC')
	public static function sql_order($sql, $order){
		if ($order) {
			if (is_array($order)) {
				list($prop, $direction) = $order;
				$order = "`$prop` $direction";
			}
			if (is_string($order)) {
				$sql .= " ORDER BY $order";
			}
		}
		return $sql;
	}

	//dd
	public static function has_db($mysqli, $order){
		if ($mysqli === true) $mysqli = static::$connection;
	}


	//https://stackoverflow.com/questions/6694437/mysqli-fetch-all-not-a-valid-function
	//https://stackoverflow.com/questions/11664536/fatal-error-call-to-undefined-method-mysqli-resultfetch-all
	//eg return _mysql::fetch_all($query);
	public static function fetch_all($queryResult, $fetch_assoc = false){
		/*if (is_callable(array($queryResult, 'fetch_all'))) {
			return $queryResult->fetch_all();
		}*/

		//иногда* $queryResult может быть boolean *при ошибках или [mb] специфических запросах или ошибках
		if (is_bool($queryResult)) {
			return $queryResult;
		}

		$results_array = array();
		$method = array($queryResult, $fetch_assoc ? 'fetch_assoc' : 'fetch_row');
		//d($method, gettype($method));
		while ($row = call_user_func($method)) {
			$results_array[] = $row;
		}
		return $results_array;
	}
}

