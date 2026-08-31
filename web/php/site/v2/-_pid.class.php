<?#4.2.1 - site uri manager


class _pid {

	static $cur; //текущий объект uri страницы

	static function init($pidData){
		$Pid = $pidData instanceof pid ? $pidData : new pid($pidData);
		static::$cur = $Pid;
		return $Pid;
	}

	static function create($uri = true, $init = false){
		if ($uri === true) $uri = pageUri;

		if ($uri === '') {
			$uri = pro('opt', 'base_pid');
		}

		$uri = urldecode($uri);
		$uri = mb_strtolower($uri);

		$Pid = new pid($uri);

		if ($init) {
			static::init($Pid);
		}

		return $Pid;
	}
}

function cur_pid($arg1 = 'name'){
	$Pid = _pid::$cur;
	//dx($Pid, $arg1);
	if (!$Pid) return null;
	if ($arg1 === true) return $Pid;

	$caller = array($Pid, $arg1);
	if (is_callable($caller)) {
		$args = array_slice(func_get_args(), 1);
		return call_user_func_array($caller, $args);
	} else {
		//base case
		return $Pid->{$arg1};
	}
}

function set_cur_pid($pid) {
	_pid::create($pid, true); //set_cur_pid()
}

/*
same cur_pid('uri', $arg1)

function cur_uri($arg1 = false){
	$method = 'uri';
	//$noticeMethod = is_bool($arg1);
	$args = func_get_args();
	//if ($hasMethod) $args = array_slice($args, 1);
	array_unshift($args, $method);
	return call_user_func_array('cur_pid', $args);
}
*/