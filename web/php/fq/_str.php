<?#2.1.2

/*
	раньше здесь были только
		attr_str#1.0
		n_str#1.1
	теперь они в fq/-d/attr/attr_val.d
*/

function str_attr($data){
	$stack = array();
	if (is_stringable($data)) {
		$data = array($data);
	}

	if (isAssoc($data)) {
		foreach ($data as $prop => $value) {
			if ($value === false) return;
			$value = ($value === null) ? '' : "=\"$value\""; //'="'.$value.'"';
			$stack []= $prop.$value;
		}
	} else if (is_array($data)) {
		$stack = $data; //{s, ao}
	}

	//падение при $stack !a

	return join(' ', $stack);
}


function str_ns($data){
	$stack = array();

	if (isAssoc($data)) {
		foreach ($data as $value => $usage) {
			if ($usage) $stack []= $value;
		}
	} else if (is_array($data)) {
		foreach ($data as $value) {
			if ($value) $stack []= $value;
		}
	} else if (is_stringable($data)) {
		$value = (string) $data;
		if ($value) $stack [] = $data;
	}

	return join(' ', $stack);
}