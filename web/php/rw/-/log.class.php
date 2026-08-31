<?#0.1

class rw_log {


	static $log = array();
	static function log($name, $data){
		if (func_num_args() > 2) $data = array_slice(func_get_args(), 1);
		if (!isset(static::$log[$name])) static::$log[$name] = array();
		static::$log[$name] []= $data;
		return $data;
	}
	static function log_(){
		$log = call_user_func_array('static::log', func_get_args());
		d($log);
	}
	static function log_x(){
		$log = call_user_func_array('static::log', func_get_args());
		dx($log);
	}


	//$cond - указание выбора из стека $log[$name]
	//  true - последний
	static function get_log($name, $cond = null){
		if (!isset(static::$log[$name])) return null;
		$log = static::$log[$name];
		//dx($log, end($log));
		if (is_null($cond)) return $log;
		if (is_true($cond)) {
			$last = end($log);
			reset($log);
			return $last;
		}
		//td find_log($cond)
	}
}