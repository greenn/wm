<?#2.5.0
/*

prop() использовать propChain а не prop_hit
propChain переделать с вариантом otherwise

*/

_addphp('fq/_is'); //is_stringable
//[oo web/test/web/php/fq/props.php]

function has_items($arr, $prop = 'items'){
	if (is_object($arr)) $arr = (array) $arr;
	return is_array($arr) && isset($arr[$prop]) && is_array($arr[$prop]) && !empty($arr[$prop]);
}


function has_prop($arr, $prop){
	if (is_object($arr)) $arr = (array) $arr;
	if (is_array($prop)) return has_prop_hit($arr, $prop);
	return is_array($arr) && is_stringable($prop) && array_key_exists($prop, $arr);
}

function has_prop_hit($arr, $props){ //проверяет есть ли в данных $arr одно из $props
	foreach ((array)$props as $tryProp) if (has_prop($arr, $tryProp)) return true;
	return false;
}


#ob prop(array('a' => null), 'a', 'b'), //b
function prop($stack, $name, $otherwise = null) { #3.0
	if (is_object($stack)) $stack = (array) $stack; //[im может если объект - просто изменить проверку для объекта 'oprop']
	if (is_array($name)) return prop_hit($stack, $name, $otherwise);
	//return is_array($stack) && array_key_exists($name, $stack) ? $stack[$name] : $otherwise;
	return is_array($stack) && isset($stack[$name]) ? $stack[$name] : $otherwise; //[или именно isset]
	/* [im]
		правильнее конечно array_key_exists вместо isset
		[p] для этого может использовать arg4 = [ak true-prop]
	*/
}
/*[im]
	возможно правильнее было бы кстати такой порядок аргументов $prop, $stack, $otherwise
	тогда бы если не передавался $stack prop($prop) = $prop. - но когда бы это было? [br]
*/

//nd/td/+
//function propSlice

#ob: array('a1' => null), array('a', 'a1'), 'b') //'b'
function prop_hit($stack, $names, $otherwise = null){
	if (!is_array($names)) $names = array($names);
	//foreach ($names as $tryName) if ($prop = prop($stack, $tryName)) return $prop;
	foreach ($names as $tryName) {
		if (has_prop($stack, $tryName)) {
			return prop($stack, $tryName);
		}
	}
	return $otherwise;
}

//получаем первое значимое свойств из $names в $stack
//дополнительные незначимые значения
//$check_default = false - ak использовать только $skip_value
//$_ctx, array('text-html', 'text', array(false, null)); - принимаем пустую строку
function prop_hit_value($stack, $names, $otherwise = null, $skip_value = array(), $check_default = true){
	static $not_value = array(false, null, '');
	if ($skip_value) $skip_value = (array) $skip_value;
	foreach ($names as $tryName) {
		if (has_prop($stack, $tryName)) {
			$prop = prop($stack, $tryName);
			$passDefault = $check_default ? !in_array($prop, $not_value) : true;
			$passCustom = $skip_value ? !in_array($prop, $skip_value) : true;
			if ($passDefault && $passCustom) {
				return $prop;
			}
		}
	}
	return $otherwise;
}

function prop_first($stack, $returnKey = false){
	if (is_object($stack)) $stack = (array) $stack;
	if (is_array($stack)) {
		foreach ($stack as $key => $value) return $returnKey ? $key : $value;
		return null; //карамелька: for empty array
	}
	return $returnKey ? 0 : $stack; //карамелька
}

function prop_filter($stack, $name, $otherwise = 0){
	return in_array($name, $stack) ? $name : prop($stack, $otherwise, $otherwise); //первый элемент из $stack или если $otherway это не ключ, то он сам
}

_addphp('fq/_prop-chain');

function is_prop($arr, $prop){
	return has_prop($arr, $prop) && prop($arr, $prop);
}