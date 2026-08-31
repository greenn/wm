<?#5.1.2335
//использование array-пути для среза контекста
//man iq/test/php/dataPath.php
/*
	это всё не работает нормально
	не может выполнить обыкновенную
		$newVal = dataPath::set(array(), array('uid'), 222);
*/

class dataPath {

	static $error;
	static function error($index = false){
		$data = static::$error;
		if ($data && is_number($index)) {
			$data = $data[$index];
		}
		return $data;
	}
		//09
		static function error_info(){
			$info = $data = static::$error;
			if ($info) {
				$info = array();
				$info['title ошибки'] = $data[0];
				$info['error prop'] = $data[1];
				$info['parent data of error prop'] = $data[2];
				$info['path tail'] = $data[3];
			}
			return $info;
		}

	static function clear_error(){
		static::$error = false;
	}
	static function set_error(){
		static::$error = func_get_args();
	}

	static $context;

	static $initAct;/*
		0 - del
		1 - set
		2 - push
		3 - merge [ff]
	*/
	static $setValue;

	static function has($context, $path){
		static::init_walk();
		static::walk($context, $path);
		return !static::error();
	}

	static function get($context, $path){
		static::init_walk();
		$slice = static::walk($context, $path);
		return $slice;
	}

	static function del($data, $path){
		static::init_walk($data, 0);
		static::walk($data, $path);
		return $data;
	}

	static function set($data, $path, $value){
		static::init_walk($data, 1, $value);
		static::walk($data, $path);
		return $data;
	}

	static function push($data, $path, $value){
		static::init_walk($data, 2, $value);
		static::walk($data, $path);
		return $data;
	}

	static function merge($data, $path, $value){
		static::init_walk($data, 3, $value);
		static::walk($data, $path);
		return $data;
	}

	static function set_key($data, $path, $key, $value){
		$upd = array();
		$upd[$key] = $value;
		return static::merge($data, $path, $upd);
	}

	static function create($data, $path, $value = null){
		//d($data, $path);
		//$i = 1;
		do {
			//d($i, $data);
			static::init_walk($data);
			static::walk($data, $path);
			$error = static::error();
			if ($error) {
				$prop = $error[1];
				$tail = $error[3];
				$isLastProp = empty($tail);
				if ($isLastProp) {
					static::$context[$prop] = $value;
					$error = false;
				} else {
					static::$context[$prop] = array();
				}
			}
			//if (++$i > 4) dx($data, $error);
		} while ($error); //stop когда false

		return $data;
	}

	static function init_walk(&$context = null, $initAct = false, $setValue = null){
		static::clear_error();
		static::$context = &$context;
		static::$initAct = $initAct;
		static::$setValue = $setValue;
	}

	static function walk($context, $path){
		$name = array_shift($path);
		$isLastName = empty($path);

		if (!is_array($context)) {
			static::set_error('wrong-value', $name, $context, $path);
			return null;
		}
		if (!array_key_exists($name, $context)) {
			static::set_error('wrong-prop', $name, $context, $path);
			return null;
		}

		$data = $context[$name];
		dx($data);
		if (!$isLastName) {
			static::$context = &static::$context[$name];
			$data = static::walk($data, $path);
		} else {
			//d(static::$initAct);
			switch (static::$initAct){
				case 0: { //case: del
					unset(static::$context[$name]);
				} break;
				case 1: { //case: set
					//dx($data, static::$context, static::$prop, static::$setValue);
					static::$context[$name] = static::$setValue;
				} break;
				case 2: { //case: push
					if (!is_array(static::$context[$name])) static::$context[$name] = array();
					static::$context[$name] []= static::$setValue;
				} break;
				case 3: { //case: merge
					if (!is_array(static::$context[$name])) static::$context[$name] = array();
					static::$context[$name] = array_merge(static::$context[$name], static::$setValue);
				} break;
			}
		}

		return $data;
	}

}