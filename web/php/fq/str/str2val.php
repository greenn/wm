<?#1.0.1

//переводит строку в другой тип, если получается
function str2val($str) {
	if (!is_string($str)) return $str;
	if (is_float($str)) return (float) $str;
	if (is_numeric($str)) return (integer) $str;
	switch ($str) {
		case 'false': return false;
		case 'true': return true;
		case 'null': case 'undefined': return null;
		default: return $str;
	}
}

function str2valDeep($data) {
	if (is_array($data)) {
		$res = array();
		foreach ($data as $key => $value) {
			$res[$key] = str2valDeep($value);
		}
		return $res;
	} else {
		return str2val($data);
	}
}
