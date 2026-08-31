<?#11.4.1359
_needphp('dataPath.class');

class s {

	static function inited(){
		return session_id() !== '';
	}

	static function init(){
		if (!static::inited() && !headers_sent()) {
			session_start();
		}
	}

# data
	static function data() {
		return isset($_SESSION) ? $_SESSION : null;
	}

	static function data_has($var) {
		$data = static::data();
		return $data && array_key_exists($var, $data);
	}

	static function data_get($var, $otherwise = null) {
		$data = static::data();
		if (!$data) return $otherwise;
		//d('data_get', $data, $var);
		if (!is_array($var)) {
			return prop( $data, $var, $otherwise);
		} else { //case: var as path
			$path = $var;
			$data = dataPath::get($data, $path);
			return !dataPath::error() ? $data : $otherwise;
			//return dataPath::has($data, $path) ? dataPath::get($data, $path) : $otherwise;
			//return dataPath($var, $data, $otherwise);
		}
	}

	static function data_set($var, $val) {
		//if (!isset($_SESSION)) return;
		return $_SESSION[$var] = $val;
	}

	static function data_set_key($var, $key, $value) {
		$data = static::data_get($var);
		if (!is_array($data)) $data = array();
		$data[$key] = $value;
		static::data_set($var, $data);
		return $data;
	}

	static function data_push($var, $value) {
		$data = static::data_get($var);
		if (!is_array($data)) $data = array();
		$data []= $value;
		static::data_set($var, $data);
		return $data;
	}

	static function data_merge($var, $value) {
		$data = static::data_get($var);
		if (!is_array($data)) $data = array();
		$data = array_merge($data, $value);
		static::data_set($var, $data);
		return $data;
	}

	
	static function data_del($var) {
		$data = static::data();
		if (!$data) return null;
		if ($var === true) {
			$_SESSION = array();
			return true;
		} else {
			if (static::data_has($var)) {
				unset($_SESSION[$var]);
				return true;
			} else {
				return false;
			}
		}
	}

# prop
	static function prop_get($propsChain, $otherwise = null){
		return static::data_get($propsChain, $otherwise);
	}
	//подготовка данных (из %path) для работы с prop
	static function prop_data($propsChain){
		$var = array_shift($propsChain);
		$val = static::data_get($var);
		//d('prop_data', $propsChain, $var, $val);
		return array($val, $propsChain, $var);
	}

	static function prop_has($propsChain){
		list($val, $path) = static::prop_data((array)$propsChain);
		//d('prop_has', $val, $path, $propsChain);
		return dataPath::has($val, $path);
	}

		static function prop_del($propsChain){
			list($val, $path, $var) = static::prop_data($propsChain);
			if (!$path) return static::data_del($var);
			$newVal = dataPath::del($val, $path);
			static::data_set($var, $newVal);
			return $newVal;
		}

		static function prop_set($propsChain, $value){
			list($val, $path, $var) = static::prop_data($propsChain);
			//dx($val, $path, $var);
			if (!$path) return static::data_set($var, $value);
			$newVal = dataPath::set($val, $path, $value);
			dx($newVal, $val, $path, $value);
			static::data_set($var, $newVal);
			return $newVal;
		}

		static function prop_set_key($propsChain, $key, $value){
			list($val, $path, $var) = static::prop_data($propsChain);
			if (!$path) return static::data_set_key($var, $key, $value);
			$newVal = dataPath::set_key($val, $path, $key, $value);
			static::data_set($var, $newVal);
			return $newVal;
		}

		static function prop_push($propsChain, $value){
			//d('prop_push', $propsChain, $value, $key);
			list($val, $path, $var) = static::prop_data($propsChain);
			if (!$path) return static::data_push($var, $value);
			$newVal = dataPath::push($val, $path, $value);
			static::data_set($var, $newVal);
			return $newVal;
		}

		static function prop_merge($propsChain, $value){
			list($val, $path, $var) = static::prop_data($propsChain);
			if (!$path) return static::data_merge($var, $value);
			$newVal = dataPath::merge($val, $path, $value);
			static::data_set($var, $newVal);
			return $newVal;
		}

	static function prop_create($propsChain, $value = null){
		list($val, $path, $var) = static::prop_data($propsChain);
		if (!$path) return static::data_set($var, $value);
		$newVal = dataPath::create($val, $path, $value);
		static::data_set($var, $newVal);
		return $newVal;
	}
# operations
	static function incr($var, $resetValue = false){
		if ($resetValue) {
			$value = is_numeric($resetValue) ? (integer)$resetValue : 0;
		} else { //case: base
			$value = static::data_get($var);
			if (!is_number($value)) $value = is_numeric($value) ? (integer)$value : 0;
		}
		return static::data_set($var, $value + 1);
	}

# sdata / serialization
	//static function sdata(){}
	//static function sdata_has(){}
	//static function sdata_get(){}
	//static function sdata_set(){}
	//static function sdata_del(){ ~ data_del}
	//static function sdata_prop(){}
	//static function sdata_prop_set(){}



#\
}