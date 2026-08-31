<?#2.3.0

_addphp('fq/_is'); //isOrdinal
_addphp('json/jsonPrettyEncode');

function valToStr($val){ //строковое представление значения-переменной |strq|str_var|val_str|valToStr|
	if (is_string($val)) {
		//$val = str_replace("'", "\'", $val);
		$val = strtr($val, array("'" => "\'"));
		$val = "'$val'";
	} else {
		$val = var_export($val);
	}
	return $val;
} //array_map('strq', $args)

function val_print($val, $asJson = false){
	print $asJson ? valToJson($val) : valToStr($val);
}

function valToJson($val){
	return jsonPrettyEncode($val);
}

//custom'ный var_export, ordinal-array without indexes
function val_export($val){
	if (isOrdinal($val)) {
		$val = array_map('valToStr', $val);
		return 'array('.join(', ', $val).')';
	} else {
		return var_export($val, true);
	}
}