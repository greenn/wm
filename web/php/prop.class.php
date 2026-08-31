<?#4.0.0 - новая версия функций prop
/*
 	ug iq/test/php/prop-class.php
	man ._/man/prop-class

	eg

		_prop::pikIn($data, 'title', array('menu-company', 'menu', 'page'));
		_prop::pik($data, array('text-descr-1', 'text-descr'));
*/

_needphp(
	//'dataPath', //
	'pathValue', //getValueByPath(), isPathExists()
	'isAssoc',
	'fq/_prop-chain'
);

function _prop($data, $prop/*{s,ao}*/, $otherwise = null){
	return _prop::get($data, $prop, $otherwise);
}

class _prop {
	//проверяем аргументы, выравниваем $prop;
	static function verify_data($value){
		return is_array($value);
	}
	static function verify_propName($value){
		return !is_null($value) && !is_bool($value) && !isAssoc($value);
		//return $value  && (is_string($value) || is_number($value) || isOrdinal($value));
			//cz не проходят 0 и ''
	}
	static function verify_propNames($valueList){
		$pass = true;
		if ($valueList) foreach ($valueList as $value) {
			$pass *= static::verify_propName($value);
		}
		return $pass;
	}
	static function verify_propList($value){
		return $value && isOrdinal($value);
	}
	static function verify_ctx($list){
		$pass = true;
		if ($list) foreach ($list as $type => $value) {
			$pass *= call_user_func("static::verify_$type", $value);
		}
		return $pass;
	}
	static function verifyArgs($data, &$prop, $list = array()){
		if (static::verify_data($data)) {
			if (static::verify_ctx($list)) {
				//d($prop, static::verify_propName($prop));
				if (static::verify_propName($prop)) {
					$prop = (array) $prop;
					return true;
				}
			}
		}
		return false;
	}

	static function __callStatic($method, $args_){

		if (substr($method, -1) == "_") {
			/*
				добавление _ в конце метода (method_), вызывает метод как chain
				ak
				static function get_($data, $prop1/*, $propN* /){
					$props = array_slice(func_get_args(), 1);
					return static::get($data, $props);
				}
			*/
			$relMethod = substr($method, 0, -1);
			$data = array_shift($args_); //первый аргумент функции
			$prop = $args_; //оставшееся args - как chain-props
			return call_user_func("static::$relMethod", $data, $prop);
		}

	}

	static function get($data, $prop, $otherwise = null){
		if (!static::verifyArgs($data, $prop)) return $otherwise;
		return static::_get($data, $prop, $otherwise);
	}
	static function _get($data, $prop, $otherwise = null){
		if (static::has($data, $prop)) {
			return getValueByPath($data, $prop);
		}
		return $otherwise; //else
	}


	static function has($data, $prop){
		if (!static::verifyArgs($data, $prop)) return null;
		return static::_has($data, $prop);
	}
	static function _has($data, $prop){
		return isPathExists($data, $prop);
	}

	static function pik($data, $propList, $otherwise = null){
		if (!static::verify_ctx(array('data' => $data, 'propList' => $propList))) return $otherwise;
		//if (!static::verifyArgs($data, $prop, array('propList' => $propList))) return $otherwise;

		return static::_pik($data, $propList, $otherwise);
	}
	static function _pik($data, $propList, $otherwise = null){
		foreach ($propList as $prop) {
			if (static::has($data, $prop)) {
				return static::get($data, $prop);
			}
		}
		return $otherwise;
	}
	static function pikIn($data, $baseProp, $subProps, $otherwise = null){
		//$subProps не может быть s
		//if (!static::verify_ctx(array('data' => $data, 'propName' => $baseProp, 'propList' => $subProps))) return $otherwise;
		if (!static::verify_ctx(array('data' => $data, 'propNames' => array($baseProp, $subProps)))) return $otherwise;
		return static::_pikIn($data, $baseProp, (array)$subProps, $otherwise);
	}
	static function _pikIn($data, $baseProp, $subProps, $otherwise = null){
		$propList = array();
		foreach ($subProps as $prop) {
			if ($prop === false) continue;
			if ($prop === null) continue;
			if ($prop === true) continue;
			$propList []= array_merge((array)$baseProp, (array)$prop);
		}
		return static::_pik($data, $propList, $otherwise);
	}

	static function set($data, $prop, $value){
		if (!static::verify_propName($prop)) return $data;
		return static::_set($data, $prop, $value);
	}
	static function _set($data, $prop, $value){
		if (!is_array($data)) $data = array();
		$prop = (array) $prop;
		if (count($prop) == 1) {
			$data[$prop[0]] = $value;
		} else {
			set_propChain($data, $prop, $value);
		}
		return $data;
	}

	static function unset($data, $prop){
		if (!static::verifyArgs($data, $prop)) return $data;
		return static::_del($data, $prop);
	}
	static function _unset($data, $prop){
		if (static::has($data, $prop)) {
			if (count($prop) == 1) {
				unset($data[$prop]);
			} else {
				static::removePropertyByPath($data, $prop);
			}
		}
		return $data;
	}

	//by gpt-4
	static function removePropertyByPath(&$arr, $path) {
		$temp = &$arr;
		foreach ($path as $key) {
			if (!isset($temp[$key])) {
				return; // Путь не существует, ничего не делаем
			}
			$temp = &$temp[$key];
		}

		// Откатываемся на один шаг назад, чтобы получить доступ к родительскому массиву
		if(count($path) > 1) {
			$lastKey = array_pop($path);
			$temp = &$arr;
			foreach ($path as $key) {
				$temp = &$temp[$key];
			}
			// Удаляем ключ в родительском массиве
			unset($temp[$lastKey]);
		} else {
			// Если путь состоит только из одного ключа, удаляем его напрямую
			unset($arr[$path[0]]);
		}
	}

	//добавляем и изменяем данные поссылке
	static function update(&$data, $prop, $value){
		if (static::verify_propName($prop)) {
			$data = static::_set($data, $prop, $value);
		}
	}

	//удаляем и изменяем данные поссылке
	static function remove(&$data, $prop){
		if (static::verifyArgs($data, $prop)) {
			$data = static::_unset($data, $prop);
		}
	}

	static function extract($data, $propList, $otherwise = array()){
		if (!static::verify_ctx(array('data' => $data, 'propList' => $propList))) return $otherwise;
		return static::_extract($data, $propList);
	}

	static function _extract($data, $propList){
		//gpt4
		$keysArray = array_flip($propList);
		return array_intersect_key($data, $keysArray);
	}

}


class props {
	var $data;
	function __construct($data){
		$this->data = $data;
	}
	function __call($method, $args_){
		array_unshift($args_, $this->data);
		return call_user_func_array("_prop::$method", $args_);
	}
}