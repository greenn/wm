<?
//[eg if (propChain($data, 'routeData', 'error')) …]
function propChain($stack, $name, $subName = null/*, $subSubName, …*/) {
	$res = $stack;
	$names = is_array($name) ? $name : array_slice(func_get_args(), 1);
	do {
		$name = array_shift($names);
		$res = prop($res, $name);
	} while (count($names) && $res);
	return $res;
}


//ak propChain_
function propChainArg($stack, $argsChain){ //$otherwise?
	array_unshift($argsChain, $stack);
	return call_user_func_array('propChain', $argsChain);
}

//er
function _propChain($stack, $name, $subName = null/*, $subSubName, …*/) {
	$res = &$stack;
	$names = is_array($name) ? $name : array_slice(func_get_args(), 1);
	$proc = true;
	do {
		$name = array_shift($names);
		if (is_array($res) && array_key_exists($name, $res)) {
			$res = &$res[$name];
		} else {
			$proc = false;
		}
	} while (count($names) && $proc);
	return $res;
}

define('SET_PROPCHAIN__EXIST_LEFT', 0);
define('SET_PROPCHAIN__EXIST_REWRITE', 1);
define('SET_PROPCHAIN__EXIST_MERGE', 2);

//eg: web/test/web/php/fq/set_propChain.php
function set_propChain(&$data, $props, $value, $existSol = SET_PROPCHAIN__EXIST_MERGE){
	$slice = &$data;
	$props = (array) $props;
	do {
		$prop = array_shift($props);

		if (!is_array($slice)) {
			$slice = array();
		}
		//d($prop);
		if (!array_key_exists($prop, $slice)) {
			$slice[$prop] = array();
		}
		if ($props) {
			$slice = &$slice[$prop];
		} else {
			//step: lastValue soliution
			switch ($existSol) {
				case SET_PROPCHAIN__EXIST_REWRITE: {
					$slice[$prop] = $value;
				} break;
				case SET_PROPCHAIN__EXIST_MERGE: {
					$prevValue = $slice[$prop];
					if (is_array($prevValue) && is_array($value)) {
						$slice[$prop] = array_replace($prevValue, $value);
					} else {
						$slice[$prop] = $value;
					}
				} break;
				case SET_PROPCHAIN__EXIST_LEFT: default: {
					//continue;
				}
			}

		}


	} while (count($props));
	return $data;
}