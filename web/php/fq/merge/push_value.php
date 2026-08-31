<?#0.7.1


function push_value(/*$arg1, $argN*/){ //push_value|stack_value|values_stack|
	$res = array();
	if (func_num_args()) {
		$args = func_get_args();
		foreach ($args as $arg) { //проходимся по всем поступившем аргументом
			if (is_valuable($arg, 0)) {
				if (isOrdinal($arg)) {
					$res = array_merge($res, $arg);
				} else {
					$res []= $arg;
				}
			}
		}
	}
	return $res;
}

function push_uvalue(){ //push_unique_value
	$args = func_get_args();
	$res = call_user_func_array('push_value', $args);
	return array_unique($res);
}


/*function push_value_(){
	return call_user_func_array('push_value', func_get_args());
	//q не является ли это копией - push_value(func_get_args())
	//q это вообще тоже самое что push_value, по легенде нужно вот так
	//function push_value_($callArgs){ return call_user_func_array('push_value', $callArgs); }
	//но нам это не нужно
}*/

//function push_any(){}