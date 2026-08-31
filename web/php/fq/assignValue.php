<?#2.0

/*
    выбирает значение относительно условий для данных (тип данных)
	[eg] web/test/web/php/fq/assignValue.php
	[ud] app/r/php/snippet/tp.route.data.inc
*/

function assignValue($data, $rules, $exist = true){
	if (!is_array($rules)) return $data;

	$else = $data;
	if (array_key_exists('else', $rules)) {
		$else = $rules['else'];
		unset($rules['else']);
	}

	foreach ($rules as $ruleName => $value) {
		switch ($ruleName) {
			case '!exist': {
				if (!$exist) return $value;
			} break;
			default: {
				if (is_callable($verFunc = "is_$ruleName")) { //verification-function
					if (call_user_func($verFunc, $data)) {
						return $value;
					}
				}
			}
		}
	}
	return $else;
}