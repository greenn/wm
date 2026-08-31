<?#2.0

_addphp('fq/_is'); //is_stringable, is_mixed

function args_arr(){
	$arr = array();

	$args = func_get_args();
	$n = func_num_args();
	$key = false;
	for ($i = 0; $i < $n; $i++) {
		$arg = $args[$i];
		if (is_stringable($key)) {
			$arr[$key] = $arg;
			$key = false;
		} else {
			if (is_mixed($arg)) {
				$arr = array_merge($arr, $arg);
			} elseif (is_stringable($arg)) {
				$key = $arg;
			} else {
				//wrong params order: bool|null as key
				//как вариант, это false от функции, которая должна была вернуть массив
				//или array_push($arr, $arg)
			}
		}
	}
	if ($key) array_push($arr, $key); //case: когда 1 аргумент или осталось что-то в конце (ну вдруг, а что с ним делать)
	return $arr;
}
function argsArr(){ //strict version of args_arr
	$arr = array(); $key = false;
	foreach (func_get_args() as $index => $arg) {
		if (is_stringable($key)) { $arr[$key] = $arg; $key = false; }
		else { is_mixed($arg) ? $arr = array_merge($arr, (array)$arg) : $key = $arg; }
	}
	return $arr;
}
function argsArrArg($arg){
	return call_user_func_array('argsArr', $arg);
}