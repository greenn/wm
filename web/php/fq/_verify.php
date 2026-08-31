<?#2.0


function not_empty($value){ return !empty($value); }

function hit_($rule, $stack, $otherwise = null){
	//d($rule, is_callable($rule), $stack);
	if (is_callable($rule)) {
		if (is_array($stack)) foreach ($stack as $item) {
			if (call_user_func($rule, $item)) {
				return $item;
			}
		}
	}
	return $otherwise;
}
function _hit($rule/*, args for hit (the last is $otherwise)*/){
	if (func_num_args() == 1) return null;
	if (func_num_args() == 2) return func_get_arg(1);
	$args = func_get_args();
	$arr = array_slice($args, 1); //удаляем первый аргумент (который $rule)
	$otherwise = array_splice($arr, -1); //отрезаем последний аргумент (который $otherwise)
	return hit_($rule, $arr, $otherwise[0]);

}
//[eg] web/test/web/php/fq/hit.php?a=2&1
function hit(){
	$args = func_get_args();
	array_unshift($args, 'not_empty');
	return call_user_func_array('_hit', $args);
}