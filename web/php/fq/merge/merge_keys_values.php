<?#1.0.4


/*
	oo
		web/test/web/php/fq/merge_keys.php
	eg
		$tokenMethod = merge_keys_values(array('handlerPath', 'uu', 'etag', 'handlerReturn'), $tokenMethod, true, false, array(1 => true));

		-   -
		$decrypt = prop($set, 'arrayDecryptor', array('page', 'query'));
		$ctx = merge_keys_values($decrypt, $data);
	\

	eg
		merge_keys_values(array('ru', 'en', 'lt'), array('Войти', 'Login', true, '-'))
*/

//создаёт массив из ключей и переданных значений из пронумерованных массивов
//keys_values_merge
//ob сначала идут набок ключей {$keys} для наборна значений {$values}
function merge_keys_values($keys, $values, $allKeys = false, $defValue = null, $defValues = false){ //array_build|keys_values_merge|merge_keys_values|
	if (isAssoc($keys)) {
		//case: (aa, ao, true)
		if (!$defValues) $defValues = array_values($keys);
		$keys = array_keys($keys);
	}
	$res = array();
	$valuesIsAssoc = isAssoc($values);
	if (is_array($keys)) {
		foreach ($keys as $index => $key) {
			$fndVal = false;
			//https://gist.github.com/greenn/b56ff97f90f85ff02dff661c16f8df70
			if ($valuesIsAssoc ? array_key_exists($key, $values) : has_prop($values, $index)){
				//d('case-1', $values, $valuesIsAssoc, $index, $key, has_prop($values, $index));
				$res[$key] = $valuesIsAssoc ? $values[$key] : $values[$index];
				$fndVal = true;
			}
			if (!$fndVal && $allKeys) {
				$res[$key] = $defValues ? prop($defValues, $index, $defValue) : $defValue;
			}
		}
	}
	return $res;
}

function merge_keys_value($keys, $value){
	$res = array();
	if (is_array($keys)) {
		foreach ($keys as $index => $key) {
			/*[ Illegal offset type for
				array(array(1,2))
				array(array())
			]*/
			$res[$key] = $value;
		}
	}
	return $res;
}