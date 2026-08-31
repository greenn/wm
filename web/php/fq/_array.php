<?#0.2.0
_addphp('isAssoc');
/*
	для < PHP 5.4
		не работает конструкция array('a', 'b')[0]
		но работает как _array('a', 'b')[0]
*/
function _array(/*array-args*/){
	$array = func_get_args();
	if (count($array) === 1 && isAssoc($array[0])) {
		$array = $array[0];
	}
	return $array;
}