<?#1.2
//oo web/test/web/php/fq/undefined.php

class undefined {
	public function __toString() {
		return '';
	}
}

function undefined($trueUndefined = false){
	if ($trueUndefined) {
		//case: undefined(true) !== undefined(?true)
		return new undefined();
	}
	//case: undefined() === undefined()
	static $value = false;
	if ($value === false) $value = new undefined();
	return $value;
}

function is_undefined($var){
	return $var instanceof undefined;
}

function not_undefined($var){
	return !is_undefined($var);
}


function array_unset_undefined($array){
	if (is_array($array)) {
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				$array[$key] = array_unset_undefined($value);
			} else if (is_undefined($value)) {
				unset($array[$key]);
			}
		}
	}
	return $array;
}

function _array_unset_undefined(&$array){
	$array = array_unset_undefined($array);
}