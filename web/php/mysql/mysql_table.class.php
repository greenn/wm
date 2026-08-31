<?#0.9.4
//расширитель для mysql.class по работе с таблицами

_needphp('log');

class mysql_table {
	var $mysql;
	function __construct($Mysql) {
		$this->mysql = $Mysql;
	}



	function exist($name){
		return (boolean)$this->mysql->query("DESCRIBE `$name`;");
	}

	//>> mysql->table_all > all_items > items_all
	function all($dbName = true){ //all|get_list|
		if ($dbName === true) $dbName = $this->mysql->db_name;
		$tbInfo = $this->mysql->query_rd("SHOW TABLES FROM `$dbName`;");

		$tbList = array();
		foreach ($tbInfo as $data) {
			$tbList []= reset($data);
		}
		//if ($getData) {}
		return $tbList;
	}


	var $def_type_length = array(
		'varchar' => 255,

		'integer' => 7,

		'text' => false,
		'mediumtext' => false,
		'longtext' => false,
		'date' => false,
		'datetime' => false,
			'timestamp' => false,
		'boolean' => false,
	);
	var $def_opt = array(
		'engine' => 'MyISAM', //InnoDB (не работает почему-то в OpenServer)
		'charset' => 'utf8'
	);

	function align_table_cfg($data){
		static $req_props = array('engine', 'charset');

		if ($data === true) $data = array();

		if (is_string($data)) {
			$data = array('comment' => $data);
		}

		foreach ($req_props as $prop) {
			if (!isset($data[$prop])) {
				$data[$prop] = $this->def_opt[$prop];
			}
		}

		return $data;
	}

	static function combine_cfg($data, $rules, $props = array(), $join_result = ' '){
		foreach ($rules as $name => $prop) {
			if (has_prop($data, $name)) {
				$value = prop($data, $name);
				$prop_value = $prop;
				if (is_string($value) || is_numeric($value)) {
					$prop_value = str_replace('%s', $value, $prop);
				}
				$props []= $prop_value;
				//d($value, $prop_value);
			}
		}
		//dx($props);
		return $join_result ? join($join_result, $props) : $props;
	}

	/*
		eg
			'id' => array('primary', 'auto-increment', 'integer'),
			'id' => array('auto-id', array('type' => 'int-3')),
			'id' => array('auto-id', 'int-3'),

			'field' => array('type' => 'string'),
			'field' => array('string'),
			'field' => 'string',
			'field' => '',
	*/
	function align_items_cfg($list){
		//dx('align_items_cfg', $list);
		foreach ($list as $index => $data) {
			//d('align_items_cfg:each', $index, $data);
			$list[$index] = $this->align_item_cfg($data);
			//d('align_items_cfg:each=', $index, $data, $list[$index]);
		}
		return $list;
	}



	var $align_type_cfg = false;
	static $_type_pattern1 = '~(%s)(?:-(\d+))?$~i'; //https://regex101.com/r/ZRe8lh/1
	static $_type_pattern2d = '~(%s)(?:(-|+)(\d+))?$~i'; //https://regex101.com/r/ZRe8lh/1
	static $_type_pattern = '~(%s)[-]?(\d+)?$~i'; //https://regex101.com/r/ZRe8lh/1
	static $_raw_type_pattern = '~([a-z]+)\((\d+)\)$~i'; //https://regex101.com/r/8hOkBc/1

	static function _unwrap_type(&$ctx){
		if (isset($ctx['type'])) {
			if (preg_match(static::$_raw_type_pattern, $ctx['type'], $match)) {
				$ctx['type'] = array($match[1], $match[2]);
			}
		}
	}

	function align_type_cfg($value){
		//d('align_type_cfg', $value);

		$orig_value = $value;
		static $_ordered_types = array(
			'tinyint' => 'tinyint', 'tiny' => 'tinyint', // 1 байт / 255 символов (-128 до 127)
			'smallint' => 'smallint', 'small' => 'smallint', // 2 байта / 65,535 символов (-32,768 до 32,767)
			'mediumint' => 'mediumint', // 3 байта / 16,777,215 символов (-8,388,608 до 8,388,607)
			'integer' => 'integer', 'int' => 'integer', // 4 байта / 4,294,967,295 символов (-2,147,483,648 до 2,147,483,647)
			'integer+' => array('integer', 'unsigned'), 'int+' => array('integer', 'unsigned'),
			'bigint' => 'bigint', // 8 байтов / 18,446,744,073,709,551,615 символов ( -9,223,372,036,854,775,808 до 9,223,372,036,854,775,807) = 16 миллионам терабайтов (или 16 экзабайтам)

			'char' => 'char', // 255 символов
			'varchar' => 'varchar', 'str' => 'varchar', 'string' => 'varchar', // 65,535 символов (64 КБ)
			'text' => 'text', // 65,535 символов (64 КБ)
			'mediumtext' => 'mediumtext', 'medium' => 'mediumtext', //16,777,215 символов (16 МБ)
			'longtext' => 'longtext', 'long' => 'longtext', //4,294,967,295 символов (4 Гб)

			'date' => 'date',
			'timestamp' => 'timestamp', 'tmp' => 'timestamp',
			'datetime' => 'datetime', 'time' => 'datetime',

			'boolean' => 'boolean', 'bool' => 'boolean',
		);


		$this->align_type_cfg = false;


		if ($value === '') {
			$value = 'string';
		}

		if (preg_match(static::$_raw_type_pattern, $value, $match)) {
			$this->align_type_cfg = true;
			$value = array('type' => $value);
		}

		if (is_integer($value)) {
			$this->align_type_cfg = true;
			$value = array('type' => array('integer', $value));
		}

		if (is_numeric($value)) {
			$this->align_type_cfg = true;
			$value = array('type' => array('varchar', $value));
		}

		//d($orig_value, $value, $this->align_type_cfg);
		if (!$this->align_type_cfg)
			foreach ($_ordered_types as $short_type => $type) {
				$pattern = sprintf(static::$_type_pattern, preg_quote($short_type));
				//d(preg_quote($short_type), $pattern, $value, preg_match($pattern, $value, $match), $match);
				if (preg_match($pattern, $value, $match)) {
					///d($value, $type, $length = prop($match, 3));
					$unsigned = false;
					$value = array($type);
					if (is_array($type)) {//case: unsigned
						$value = array($type[0]);
						$unsigned = $type[1] === 'unsigned';
					}

					if ($length = prop($match, 2)) {
						$value []= $length;
					}
					$value = array('type' => $value);
					if ($unsigned) $value['unsigned'] = $unsigned;
					$this->align_type_cfg = true;

					//d($value, $type, $match, $length, $unsigned);
					break;
				}
			}


		return $value;
	}

	//приводим конфигурацию таблицы к общему виду
	//oo iq/test/sd/struct.php
	function align_item_cfg($data){
		$org_data = $data; //dbg
		static $_ordered_props = array('auto-increment', 'primary', 'unique'); //превращаем их в prop со значением true
		static $_ordered_short_props = array('auto-id' => array('auto-increment', 'primary')); //алиасы для значений

		$item = array();

		if (isAssoc($data)) {
			$item = $data;
		}

		if (is_string($data) || is_numeric($data)) {
			//if (!$data) $data = is_string($data) ? 'string' : 'integer';
			$data = array('type' => $data);
		}

		//d('step 0:', $org_data, $data, isOrdinal($data));

		if (isAssoc($data)) {
			$item = $data;
		}

		if (isOrdinal($data)) {
			//d('step 1:', $org_data, $data);

			//step: подменяем сначала short_props
			foreach ($data as $index => $value) if (is_string($value) || is_numeric($value)) {
				//d($value);
				if ($short_prop_value = prop($_ordered_short_props, $value)) {
					$data[$index] = $short_prop_value;
					continue;
				}

				$type_value = $this->align_type_cfg($value);
				//dx($type_value);
				if ($this->align_type_cfg) {
					$data[$index] = $type_value;
					continue;
				}
			}

			//d('step 2:', $data);

			//step: расскрываем ordinal значения
			foreach ($data as $index => $value) {
				if (isOrdinal($value)) {
					unset($data[$index]);
					$data = array_merge($data, $value);
				}
			}


			//d('step 3:', $org_data, $data);
			//step: собираем итоговый конфиг
			foreach ($data as $value) {
				//step: расскрываем assoc данные
				if (isAssoc($value)) {
					$item = array_merge($item, $value);
					continue;
				}

				//step: расскрываем ordered props (true props)
				if (in_array($value, $_ordered_props)) {
					$item[$value] = true;
					continue;
				}
			}

		}

		//step: работаем сщ значение default (преобразуем / приводим)
		if (isset($item['def'])) {
			$item['default'] = $item['def'];
			unset($item['def']);
		}
		if (isset($item['default'])) {
			if (is_numeric($item['default'])) {
				$item['default-clear'] = $item['default'];
				unset($item['default']);
			}
		}



		//d('step 4:', $org_data, $data, $item, @$item['type']);
		//step: выравниваем итоговый конфиг
		//[mp]
		//if (!@$item['type']) d($item['type'], $item['type'], $org_data);

		if (is_string($item['type'])) {
			$type_value = $this->align_type_cfg($item['type']);
			if ($this->align_type_cfg) {
				$item['type'] = $type_value['type'];
			}
		}

		//step: образуем результат для типа поля в базе
		if (is_array($item['type'])) {
			if (!isset($item['type'][1])) {
				$type = $item['type'][0];
				$item['type'][1] = prop($this->def_type_length, $type, false);
			}
			list($type, $length) = $item['type'];
			$item['type'] = $length ? "$type($length)" : $type;
			if ($unsigned = prop($item, 'unsigned')) {
				$item['type'] .= ' unsigned';
			}
		}


		//dx($item);
		return $item;
	}

	/*
		man
			https://dev.mysql.com/doc/refman/8.0/en/create-table.html
	*/
	var $created_cfg;
	var $created_fields;

	static $item_props = array(
		'type' => '%s',
		'primary' => 'PRIMARY KEY',
		'unique' => 'UNIQUE KEY',
		'auto-increment' => 'AUTO_INCREMENT',
		'not-null' => 'NOT NULL', '!' => 'NOT NULL',
		'null' => 'NULL', '!!' => 'NULL',
		'comment' => "COMMENT '%s'",
		'default' => "DEFAULT '%s'",
		'default-clear' => "DEFAULT %s",
	);
	static $table_props = array(
		'engine' => 'ENGINE=%s',
		'charset' => 'DEFAULT CHARSET=%s',
		'comment' => "COMMENT='%s'",
	);
	function create($table_name, $items_cfg, $table_cfg = true){
		if ($this->exist($table_name)) {
			return $this->mysql->set_error("Table '$table_name' already exist");
		}


		$items = $this->align_items_cfg($items_cfg);
		//dx($items, $items_cfg);

		$fields = array();
		foreach ($items as $field => $set) {
			//d($field, $set);
			$fields []= static::combine_cfg($set, static::$item_props, array("`$field`"));
		}
		$_fields = join(', ', $fields);
		//dx('mc_table/create items-cfg', $items, $fields);

		$table_opts = $this->align_table_cfg($table_cfg);
		$_opts = static::combine_cfg($table_opts, static::$table_props);
		//dx('mc_table/create: table-cfg', $table_cfg, $table_opts, $_opts);


		$sql = "CREATE TABLE `$table_name` ($_fields) $_opts;";
		//$sql = "CREATE TABLE [IF NOT EXISTS] `$table_name` ($_fields) $_opts;";
		//dx('mc_table/create', $table_name, $_fields, $sql);

		//ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Тексты ';
		//dx($sql);
		$res = $this->mysql->query($sql);
		$this->created_fields = $items;
		$this->created_cfg = $items_cfg;
		///print slog('mc_table/create', "таблица '$table_name' создана", array('sql' => $sql, 'ok' => $res, 'успешно' => static::exist($table_name)));
		//slog('mc_table/create', "создание таблицы '$table_name'", array('sql' => $sql, 'ok' => $res, 'успешно' => static::exist($table_name), 'struct' => $fields, 'data' => $items_cfg));
		///d('mc_table/create', "таблица '$table_name' создана", array('sql' => $sql, 'ok' => $res, 'успешно' => static::exist($table_name)));
		///dx($sql, $res, $this->mysql->error());
		return $res;
	}

	function clear($tableName){
		$sql = "TRUNCATE TABLE `$tableName`;";
		$res = $this->mysql->query($sql);
		//dx($sql, $res, $this->mysql->error());
		return $res;
	}

	function delete($tableName){
		$sql = "DROP TABLE `$tableName`;";
		$res = $this->mysql->query($sql);
		//dx($sql, $res, $this->mysql->error());
		return $res;
	}

	function delete_all(){
		$list = $this->all();
		foreach ($list as $item) {
			$tbName = $item[0];
			$this->delete($tbName);
		}
		return !mc::table_all();
	}

	//dd
	function update($tableName){
		/*
			Indexes for table `persons`
				ALTER TABLE `persons`
					ADD PRIMARY KEY (`id`),
					ADD UNIQUE KEY `email` (`email`);


			AUTO_INCREMENT for table `persons`
				ALTER TABLE `persons`
                    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
		*/
	}

	//oo php/mysql/mysql.class.php:148
	function count($tbName, $where){
		$sql = _mysql::sql("SELECT COUNT(*) FROM `%s`", $tbName, $where);
		return $this->mysql->query_r($sql);
	}

}