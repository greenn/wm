<?#0.1.0

//array-merge
function am(/*$arg1, $argN*/){
	$res = array();
	if (func_num_args()) {
		$args = func_get_args();
		foreach ($args as $arg) { //проходимся по всем поступившем аргументом
			if (is_array($arg)) {
				$res = array_replace_recursive($res, $arg);
			}
		}
	}
	return $res;
}
