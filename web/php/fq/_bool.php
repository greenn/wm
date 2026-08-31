<?#0.2.1

//oo web/test/web/php/fq/bool.php

//превращает данные в bool-эквивалент
//ak convert2bool
function boolConvert($data, $extraFalseData = array('undefined'), $baseFalseData = array('false')){
	if (is_string($data) && ($data !== '')) {
		$value = strtolower($data);
		$data = true;
		if (is_array($baseFalseData)) {
			$data *= in_array($value, $baseFalseData);
		}
		if (is_array($extraFalseData)) {
			$data *= in_array($value, $extraFalseData);
		}
	} elseif (is_object($data)) {
			//q причём тут в boolConvert приведение set-данных \qu=0 ~ rb | rn-hardBoolConvert
			//aa для return \sr
		if (class_exists('set') && $data instanceof set) {
			$data = $data->data; //установленные опции
		} else {
			$data = (array) $data;
		}
	}
	return !empty($data);
}

//заменяется предоставленную $data - на bool-экыивалент - по правилам
function provideBool(&$data, $prop = null, $createVal = null){ //provideBool|provideBool
	$v = func_num_args();
	if ($v > 1) {
		if (is_object($data)) {
			if (property_exists($data, $prop)) {
				$data->{$prop} = boolConvert($data->{$prop});
			} elseif ($v > 2) {
				$data->{$prop} = boolConvert($createVal);
			}
		} elseif (is_array($data)) {
			if (array_key_exists($prop, $data)) {
				$data[$prop] = boolConvert($data[$prop]);
			} elseif ($v > 2) {
				$data[$prop] = boolConvert($createVal);
			}
		}
	} else {
		$data = boolConvert($data);
	}
	return $data;
}


