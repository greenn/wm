<?#2.0.1

//create assoc array, через перечисление - свойство, значение, ..., свойство, значение
function make_arr($name = null, $val = null){ //n - new //[rb key-next]
	$arr = array();
	$args = func_get_args();
	foreach ($args as $index => $arg) {
		if ($index % 2 === 0) $prop = $arg; else $arr[$prop] = $arg;
	}
	return $arr;
}
//[lj]
function nArr(){
	return call_user_func_array('make_arr', func_get_args());
}

function make_obj(){
	return (object) call_user_func_array('make_arr', func_get_args());
}
//[lj]
function nObj(){
	return  call_user_func_array('make_obj', func_get_args());
}

