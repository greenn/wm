<?#1.1.1336
	/*
	    svar static-var
		cvar context-variable
		local-context
		static-context
		vvar values
		xv
		xvar
	 */

/*
	oo
		php/x/_x.php

		php/x.php
*/

class xvar {
	/*
	    dc
			нужен ли здесь private
			наверное не нужен,
				тогда излишние методы: get_list, set_list
			в этом случае static::$list не работает, поэтому используем self::$list
	*/
	private static $list = array(); //локальный static storage
	static function get_list(){
		return self::$list;
	}
	static function set_list($list){ //, $method
		return self::$list = $list;
	}

	static function set($var, $value){
		return self::$list[$var] = $value;
	}
	static function has($var){
		return array_key_exists($var, self::$list);
	}
	static function get($var, $otherwise = null){
		return static::has($var) ? self::$list[$var] : $otherwise;
	}
	
	static function delete($var) {
		if (!static::has($var)) return false;
		unset(self::$list[$var]);
		return true;
	}

	static function incr($var) {
		$value = static::get($var);
		if (!is_number($value)) $value = is_numeric($value) ? (integer)$value : 0;
		return static::set($var, $value + 1);
	}
	static function decr($var) {
		$value = static::get($var);
		if (!is_number($value)) $value = is_numeric($value) ? (integer)$value : 0;
		return static::set($var, $value - 1);
	}
}
