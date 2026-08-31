<?#0.3.0 - css viewport unit
/* eg
	<?=_vw($ph, MQ1, 0)?>
		выставит {$val}vw которое посчитает от значения $ph для ширины MQ1

*/
function _vu($input, $size, $precision = -1) {
	$val = $input / $size * 100;
	$val = $precision < 0 ? floor($val) : round($val, $precision);
	return $val;
}
function _vw($input, $size, $precision = -1) {
	return _vu($input, $size, $precision).'vw';
}
function _vh($input, $size, $precision = -1) {
	return _vu($input, $size, $precision).'vh';
}
function _vp($input, $size, $precision = -1) {
	return _vu($input, $size, $precision).'%';
}

//подсчёт процента от числа
function _pct($value, $pct, $precision = -1){
	if (is_string($pct)) $pct = (float)rtrim($pct, '%');
	$res = $value * $pct / 100;
	return $precision < 0 ? floor($res) : round($res, $precision);
}