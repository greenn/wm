<?#0.1.0

//boolean-merge
function bm(/*$arg1, $argN*/){
	$res = false;
	if (func_num_args()) {
		$args = func_get_args();
		foreach ($args as $arg) { //проходимся по всем поступившем аргументом
			$res += (boolean)$arg;
		}
	}
	return $res;
}
