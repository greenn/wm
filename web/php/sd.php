<?#0.5
/*

*/
_addphp('sd/_sd.class'); //_sd{}
_addphp('sd/sd.class'); //sd{}


function _sd($name, $method = false/*, a, r, g, s*/){ //$name|$tbName|$sdName
	static $cache = array();
	if (!isset($cache[$name])) {
		$cache[$name] = new sd($name);
	}

	$sd = $cache[$name];
	$args_ = array_slice(func_get_args(), 2);
	//dx($sd, is_callable(array($sd, $method)), $args_);
	return $method ? call_user_func_array(array($sd, $method), $args_) : $sd;
}