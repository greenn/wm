<?#1.1.411
/*

*/
_needphp(
	'mysql/_mysql.class',
	'mysql/mc.class',
	'fq/merge/merge_keys_values'
);

class sd {
	protected $type;
	private $name;
	protected $struct_fields;
	private $rel_fields;
	private $fields_order;
	private $data_fields_order; //without id (primary keys)
	function __construct($tbName) {
		$this->name = $tbName;
		$this->set_struct();
	}

	//q private / q need arg
	function set_struct($data = true) {
		if ($data === true) {
			$data = _sd::info_get($this->name);
		}
		$this->set_struct_fields($data);
		$this->fields_order = array_keys($data);
		$this->data_fields_order = array_slice($this->fields_order, 1); //типо удаляем первое поле которое key [ух, на тоненького]
		//d($this);
	}

	function set_struct_fields($data){
		$this->struct_fields = $data;
		$this->rel_fields = array();
		foreach ($data as $name => $item) {
			if (!prop($item, 'auto-build')) {
				//d('sd/set_struct_fields:each', $name, $item);
				if (prop($item, 'rel-fields')) {
					//d('sd/set_struct_fields:rel', $name, $item);
					$relType = $item['sd'];
					$this->rel_fields[$name] = array('rel' => $relType);
				}
			}
		}
	}

	function set(){}

	//используется в add/get
	function prepare_data($data, $defField = true){
		$orig_data = $data; //dbg
		//step: определяем одиночное значение
		if (is_stringable($data)) {
			$value = $data;
			$data = array();
			$field = $defField === true ? $this->data_fields_order[0] : $defField;
			$data[$field] = $value;
		}

		//step: разбираем ordered-данные
		if (isOrdinal($data)) {
			$data = merge_keys_values($this->data_fields_order, $data);
		}

		/*
			//step: pick allowed data /01
			$_data = array();
			foreach ($this->fields_order as $allowed_field) {
				if (isset($data[$allowed_field])) $_data[$allowed_field] = $data[$allowed_field];
			}
			$data = $_data;
		*/

		if ($data === true) {
			$data = array(); //all
		} else if ($data === false) {
			$data = array('1' => '0');
		}
		//dx('sd:prepare_data', $orig_data, $data);

		//d($data);
		return $data;
	}



		function verify_value_type($value, $struct){
			dx('sd/verify_value_type', $value, $struct);
		}

	function add($data){

		//dx($this->struct_fields, $data, $this->prepare_data($data));
		$data = $this->prepare_data($data);

		//foreach ($this->struct as $field)

		$values = array();
		foreach ($data as $name => $value) {
			$relField = prop($this->rel_fields, $name); //есть не у всех, только у сформированных структур (сохранённых в sd-таблице)
			$structField = prop($this->struct_fields, $name);
			//$isRel = propChain($this->rel_fields, $name, 'rel');
			$isRel = prop($relField, 'rel');
			$isRelSd = $isRel === 'sd'; //mean: связанное добавление
			$relTable = prop($structField, 'rel-table');
			//d('sd/add:each', $name, $value, $structField, $relField);
			///
			if ($isRelSd) {
				//case: "sd:"
				//dx('sd/add:sd', $name, $value, $structField, $relField);
				$_value = _sd($relTable, 'add', $value);
				$values[$name] = $_value;

			} else {

				if ($isRel) {
					//case: "rel:"
					//$this->verify_value_type($value, $structField)
					//q if ($getId = !is_numeric($value)) {
					if ($getId = !is_integer($value)) {
						//dx('sd/add:rel', $name, $value, $relTable, $structField, $relField);
						$_value = _sd($relTable)->get_id($value, true); //создать если нету
						//dx('sd/add:rel', $name, $value, $structField, $relField, $_value, mc::last_sql());
						$value = $_value;
					}
				}

				//case: default
				$values[$name] = $value;

			}
		}

		//dx($values);
		return $this->_add($values);
	}

	function _add($values){
		$new_id = mc::item_add($this->name, $values);
		//d('sd/add', 'добавление записи', $new_id, $values);
		return $new_id;
	}


	function remove_where($prop, $value){
		$where = array();
		$where[$prop] = $value;
		return $this->remove($where);
	}

	function set_where($value) { //sweet_where|prepare_where|set_where
		$where = $value;
		if (is_stringable($value)) {
			$where = array();
			$where['id'] = $value;
		}
		return $where;
	}

	function remove($data){
		$res = null;
		$where = $this->set_where($data);
		if (isAssoc($where)) {
			//d('sd/remove', $this->name, $where);
			$res = mc::item_delete($this->name, $where);
		}
		return $res;
	}


	//dm
	function verify_data($data, $where){}

	function update($where, $data){
		$where = $this->set_where($where);
		//$data = $this->verify_data($data);
		$res = mc::item_update($this->name, $data, $where);
		return $res;
	}

	function all($resByProp = false){
		$res = $list = $this->get_all(true);
		//dx($list);
		if ($resByProp) {
			$res = array();
			foreach ($list as $item) {
				$key = $item[$resByProp];
				$res[$key] = $item;
			}
		}
		return $res;
	}
	//[vz]
	function all_v2($order = false){
		return mc::item_all($this->name, $order);
	}



	function align_fields_type($data){
		foreach ($data as $name => $value) {
			$field = $this->struct_fields[$name];

			//step: проверка на integer
			$reqInt = false;
			$isInt = is_integer($value);
			if (prop($field, 'auto-build')) {
				$reqInt = startsWith($field['Type'], 'int');
			} else {
				$reqInt = propChain($field, 'fields', 'type', 0) === 'integer';
			}
			//d($name, $value, $reqInt, $isInt);
			if ($reqInt && !$isInt) {
				$data[$name] = (int)$value;
			}
			//\
		}
		return $data;
	}

	//nc: единственный метод получения из базы
	function get($props, $where, $order = false){
		$_where = $this->prepare_data($where, 'id');
		$res = mc::item_get($props, $this->name, $_where, $order);
		if ($res) foreach ($res as $index => $row) {
			$res[$index] = $this->align_fields_type($row);
		}
		//dx($res);
		return $res;
	}
	function get_all($where, $order = false){
		//$where = $this->prepare_data($where);
		return $this->get('*', $where, $order);
	}
	function get1($props, $where, $order = false){
		$res = $this->get($props, $where, $order);
		return $res ? $res[0] : null;
	}
	function get1_prop($prop, $where, $order = false){
		$res = $this->get1($prop, $where, $order);
		return $res ? $res[$prop] : false;
	}
	function get1_all($where, $order = false){
		$res = $this->get1('*', $where, $order);
		return $res;
	}

	function get_id($value, $createIfNotExist = false){
		//$where = $this->prepare_data($value);
		$id = $this->get1_prop('id', $where);
		if (!$id && $createIfNotExist) $id = $this->add($value); //rb get_ensure_id
		return $id;
	}
	function get_value($where, $value_prop = 'value'){
		//$where = $this->prepare_data($where);
		$id = $this->get1_prop($value_prop, $where);
		return $id;
	}

	function has($where){ //|exist|isset|has_value|has|has_item|
		//$where = $this->prepare_data($where);
		$res = $this->get_all($where);
		//dx($where, $res, count($res), mc::last_sql());
		return count($res);
	}

	//|exist|isset|has_value|
	//function
}

