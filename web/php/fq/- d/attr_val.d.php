<?#ddd

/*
	настраиваемые опции можно ввести через первый аргумент, если он array()
*/
function attr_val($attrName = null, $attrVal = null/*, $attrValN*/){
	$str = '';
	if ($attrName) $str = (string)$attrName;

	if (func_num_args() > 1) {
		$vals = array();
		$args = array_slice(func_get_args(), 1);
		foreach ($args as $arg) {
			//…
		}

		if (!empty($vals)) {
			$str .= '="'.join(' ', $vals).'"';
		}
	}
	return $str;
}




/* вывести строковое значение
	%1  настройки вывода
			если это строка, то значит это соединительное $glue
			если цифра, то тип вывода
				1 - join-через-пробел
				2 - 1 + wrap(в двойные кавычки)
	%N  набор значение для вывода
*/
function str_val($conf = ' ', $arg1 = null/*, $argN*/) {

}




#   -   -   -   rw

#1.0.1 - строка атрибутов
/* [u/надо разбираться]
		это стек пар атрибутов
*/
//0
function attr_str($data, $rfc = 'RFC_WAS17') { //web(v17)-attr_str
	$res = array();
	foreach ($data as $name => $val) {
		if (is_stringable($val)) {
			$res []= "$name=\"".htmlspecialchars($val)."\"";
		} elseif (is_null($val)) { //RFC_WAS17: null - non-value-attr
			$res []= $name;
		} //RFC_WAS17: false - skip
	}

	$res = join(' ', $res);
	return $res;
}


#1.1.1 - строка имён
/* [uuu/надо разбираться]
		это вывод элементов через пробел
		с возможным одиночным пробелом спереди
*/
//0s
function n_str($data, $spShift = false) {
	$res = array();
	if($data) foreach ($data as $name) {
		if (is_valuable($name, 0)) {
			$res []= is_array($name) ? n_str($name) : $name;
		}
	}

	$res = join(' ', $res);
	if ($spShift && $res) $res = ' '.$res; //0
	return $res;
}