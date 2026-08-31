<?#2.2.1

_addphp('fq/arr/make_arr');
_addphp('isOrdinal');

#0.2
//tt/tg
function array_pick($src, $keys, $allKeys = false, $defValue = null, $defValues = false){
	$res = $allKeys ? merge_keys_values($keys, array(), true, $defValue, $defValues) : array();
	if (is_array($src)) {
		if (isOrdinal($keys)) {
			foreach ($keys as $key) {
				if (array_key_exists($key, $src)) {
					$res[$key] = $src[$key];
				}
			}
		} else {
			foreach ($keys as $key => $new_key) {
				if (array_key_exists($key, $src)) {
					$res[$new_key] = $src[$key];
				}
			}
		}
	}
	return $res;
}

//dd/tt
function array_ensure($value, $leftUnchanged = false, $transformOpt = null){
	if ($leftUnchanged === true){
		$leftUnchanged = array(null);
	}

	if (!is_array($value)) {
		if ($leftUnchanged && !in_array($value, $leftUnchanged)) {
			if ($value === false || $value === '') {
				//mb $transformOpt - для true
				$value = array();
			} else {
				$value = (array)$value;
			}
		}
	}
	return $value;
}
function _array_ensure(&$value, $leftUnchanged = false){
	$value = array_ensure($value, $leftUnchanged);
}


function array_push_key(&$array, $index, $item){
	if (!isset($array[$index])) $array[$index] = array();
	array_push($array[$index], $item);
}