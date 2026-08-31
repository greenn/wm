<?#1.1.5
/*

*/
_addphp('mysql/mc.class'); //mc{}
//_addphp('mysql/_mysql.class'); //mysql{}, _mysql{}


class _sd {
	static $tbName = 'sd';
	static function info_init($tbName = true){
		//ak: info_init
		if (is_string($tbName)) static::$tbName = $tbName;
		if ($tbName === true) $tbName = static::$tbName;
		if (!mc::table_exist($tbName)) {

			mc::table_create($tbName, array(
				'sd' => array('string', 'unique', array('comment' => 'sd table-name')),
				'type' => array('50', array('comment' => 'sd type')),
				'cfg' => array('text', 'not-null', array('comment' => 'JSON')),
			));
			//dx(100);
		}
	}
	static function info_save($tbName, $type, $sdInfo){
		$res = mc::item_add(static::$tbName, array(
			'sd' => $tbName,
			'type' => $type,
			'cfg' => json_encode($sdInfo), //$tbStruct|$sdInfo|
		));

		slog('_sd/info_save', "информация сохранена '$tbName' ($type)", array('ok' => $res, 'struct' => $sdInfo));
		//dx($res);
	}

	static function info_get_sd($tbName){
		$res = null;
		$data = mc::item_get1_all(static::$tbName, array(
			'sd' => $tbName,
		));

		//d($tbName, $data);
		if ($data) {
			$res = json_decode($data['cfg'], true);
		}
		return $res;
	}

	static function info_get_auto($tbName, $autoInfo = false){
		$res = array();
		$info = mc::item_get_fields($tbName);
		if ($info) foreach ($info as $item) {
			$fdName = $item['Field'];
			$data = $item;
			$data['auto-build'] = true;
			$res[$fdName] = $data;
		}
		return $res;
	}

	static function info_get($tbName){
		$res = static::info_get_sd($tbName);
		if (!$res) {
			$res = static::info_get_auto($tbName);
		}
		return $res;
	}

	//получить унифицированную информацию о таблице
	static function struct_info($tbName, $prop = false){
		$struct = array();
		$fields = array();

		$info = static::info_get_auto($tbName);
		foreach ($info as $name => $item) {
			//case: auto-info
			$isRel = false;

			$isKey = in_array($item['Key'], array('PRI'));
			//$isKey = $item['Extra'] === 'auto_increment';
			$isReq = $item['Null'] === 'Yes';


			$type = 'string';
			preg_match(mysql_table::$_raw_type_pattern, $item['Type'], $match);
			if ($match) {
				if ($match[1] == 'int') $type = 'integer';
				$type_length = $match[2];
			} else {
				$type = $item['Type'];
				$type_length = false;
			}


			$field = array(
				'isKey' => $isKey,
				'isRel' => $isRel,
				'isReq' => $isReq,
				'type' => $type,
				'type_length' => (integer) $type_length,
			);
			$struct[$name] = $field;

			unset($field['isKey']);
			if (!$isKey) {
				$fields[$name] = $field;
			}
		}

		$res = array(
			'fields' => $fields,
			'struct' => $struct,
		);

		return $prop ? prop($res, $prop) : $res;
	}

		private static $temp = array();
		static function temp_add($name, $val){
			static::$temp[$name] = $val;
		}
		static function temp_reset(){
			static::$temp = array();
		}






	static function apply_struct($tbName, $data){
		$struct = static::make_struct($data);
		list($fields, $info) = static::create_struct_tables($struct);
		//d('sd-create-final-table', $tbName, $data, $struct, $fields, $info);
		$res = mc::table_create($tbName, $fields);
		mc::__set('table_created_fields', $info);
		//d('_sd/apply_struct=', $struct, $res, $fields, $info);

		return $res;
	}

	//парсим структуру таблицы по входным данным
	static function make_struct($fields, $idOpt = array()) {
		static $sepType = ':';
		static $sepName = ' = ';

		$struct = array();
		//d('_sd:make_struct', $fields, $idOpt);
		$idSet = array('auto-id', 'int-5');
		//$idSet = array('auto-id', 5);
		if ($idOpt) $idSet = array_merge($idSet, $idOpt);
		$struct['id'] = array('sd' => false, 'set' => $idSet);


		foreach ($fields as $field => $data) {
			//d('sd/make_struct:each', $field, $data);
			$sd = false; $name = $field; $relName = false;

			if (strpos($field, $sepName) !== false){
				list($name, $relName) = explode($sepName, $field);

				if (strpos($relName, $sepType) !== false){
					list($sd, $relName) = explode($sepType, $relName);
				}
			}

			//dx($relName, $data);

			$struct[$name] = array(
				'sd' => $sd,
				'set' => $data,
				'rel-table' => $relName,
			);
		}

		return $struct;
	}

	static function create_struct_tables($struct) { //process~|build~|use_struct|
		$fields = array();
		$info = array();
		foreach ($struct as $fdName => $cfg) {
			$info[$fdName] = array('name' => $fdName) + $cfg;

			if ($cfg['sd']) {
				//step: создаём таблицу (через общую функцию)
				$relName = $cfg['rel-table'];
				$res = static::create($cfg['sd'], $relName, $cfg['set']);

				//step: вместо поля этой таблицы добавляем индекс (ссылающийся на id в той таблице)
				$fields[$fdName] = prop($cfg, 'sd-set', 'int-5');

				$info[$fdName]['rel-fields'] = mc::__get('table_created_fields');
				///$info[$fdName]['sd'] = $cfg['sd']; //sd, rel
			} else {
				$fields[$fdName] = $cfg['set'];

				$info[$fdName]['rel-fields'] = false;
			}

			$info[$fdName]['fields'] = mc::table_align_item_cfg($fields[$fdName]);
			mysql_table::_unwrap_type($info[$fdName]['fields']);
		}

		return array($fields, static::prepare_struct_info($info));
	}

		static function prepare_struct_info($info){
			foreach ($info as $tbName => $tb) {
				$sd = prop($tb, 'sd');
				if ($sd === 'rel') {}
			}
			return $info;
		}



	static function create($sdType, $tbName, $tbFields){
		$res = null;

		if (!$tbFields) return false; //case: $cfg['set'] = false

		if ($sdType === true || $sdType === 'sd') $sdType = 'base-value';

		//d('_sd:create', $sdType, $tbName, $tbFields);

		switch ($sdType) {
			case 'base-value': {
				if (mc::table_exist($tbName)) return true;

				$idSet = array('auto-id', 5);
				$valueSet = $tbFields;
				$struct = array(
					'id' => $idSet,
					'value' => $valueSet
				);
				//d('_sd:create/base-value', $tbName, $struct);
				$res = mc::table_create($tbName, $struct);

			} break;

			case 'multi-value': {
				$res = static::apply_struct($tbName, $tbFields);
			} break;

			default: {
				d('unknown sd-type', $sdType, $tbName, $tbFields);
				return null;
			}
		}

		static::info_save($tbName, $sdType, mc::__get('table_created_fields'));
		return $res;
	}
}