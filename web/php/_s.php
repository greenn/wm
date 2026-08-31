<?#10.3.19
/* про сессии
	_needphp('_s/init'); - использовать и запусктить сессию
*/

_needphp(
	'_s/s.class',
	'_s/sp.class'
);

function _s(){
	switch(func_num_args()) {
		case 0: return s::data();
		case 1: return s::data_get(func_get_arg(0));
		case 2: {
			$arg1 = func_get_arg(0);
			$arg2 = func_get_arg(1);
			if ($arg1 === true) {
				//dx($arg2, s::data_has($arg2));
				return s::data_has($arg2);
			} elseif ($arg1 === null) {
				return s::data_del($arg2);
			} else {
				return s::data_set($arg1, $arg2);
			}
		} break;
		case 3: {
			$arg1 = func_get_arg(0);
			$arg2 = func_get_arg(1);
			$arg3 = func_get_arg(2);

			if (is_bool($arg1)) { //{t,f}
				//case: использовать значение по умолчанию $arg3
				//d($cmd = $arg1, $name = $arg2, $def = $arg3);
				if (_s(true, $arg2)) {
					//case 0: вернуть текущее значение
					return _s($arg2);
				} else {
					if ($arg1 === true) {
						//case 1 (true, $sn, $setValue): установить значение по умолчанию, если оно не стоит
						//dx($arg3);
						return _s($arg2, $arg3);
					} else {
						//case 2 (false, $sn, $defValue): вернуть значение по умолчанию
						return $arg3;
					}
				}
			}
		}
	}
}

/*
	mb
		sp($var, $propPath, $value)
		sp($propPath, $value)
*/
function _sp(){
	$arg1 = func_get_arg(0);
	$arg1 = (array)$arg1;
	switch(func_num_args()) {
		case 1: return s::prop_get($arg1);
		case 2: {
			$arg2 = func_get_arg(1);
			$arg2AsPath = (array)$arg2;
			//dx($arg1, $arg2);
			if ($arg1 === true) return s::prop_has($arg2AsPath);
			elseif ($arg1 === null) return s::prop_del($arg2AsPath);
			else return s::prop_set($arg1, $arg2);
		}
		case 3: case 4: {
			$args = array_slice(func_get_args(), 1);
			return call_user_func_array("s::prop_$arg1", $args);
		}
	}
}

