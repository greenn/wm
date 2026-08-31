<?#0.1

class rw_x {


	static $x = 'rw_def';

	static function x($prop = null, $otherwise = null){
		//[ta] локальный static x и dataPath - быстрее ли и насколько от текущего
		$data = x(static::$x);
		if (!$prop) return $data;
		return prop($data, $prop, $otherwise);
	}

	static function xSlice($prop1 = null, $prop2 = null/*, $propN*/){
		switch (func_num_args()) {
			case 0: return x(static::$x); //0
			case 1: return static::x($prop1); //0
			case 2: return prop(static::x($prop1), $prop2);
			default: //0
				$dataPath = func_get_args();
				return x_slice_path(static::$x, $dataPath);
		}
	}



	//значение
	static function val($name/*, slice-args*/){ //|set|val|value|opt|
		$args = func_get_args();
		array_unshift($args, 'val');
		return call_user_func_array('static::xSlice', $args);
	}

	//names for css: classes, id
	static function nc($name = true, $subName = false){
		if ($name === true) $name = 'base';
		$n = static::xSlice('nc', $name);
		if (!$n) $n = $name === 'base' ? static::$x : static::nc('base', $name);
		if ($subName) $n .= "-$subName";
		return $n;
	}

}