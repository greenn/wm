<?#0.2.1

//переводит значение в строку
function val2str($val) {
	$str = '';
	if ($val === null) $str = 'null';
	elseif ($val === false) $str = 'false';
	elseif ($val === true) $str = 'true';
	elseif (is_array($val)) $str = json_encode($val);
	else $str = (string) $val;
	return $str;
}