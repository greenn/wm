<?#1.0.1

define('XN_LAST_DEC_CSS_VALS', 'last_dec_css'); //результат последних вычислений в dec_css

/*


dec_set(conf, times = )

conf - настройки
times - смена настроек на колливо раз
	true - на всё время
	1 - на один раз

dec_set(false)
	востановление по умолчанию

*/


/*
	уменьшение значения в процентном отношении
		$minCeil - значение после которого округлять в большую сторону
		$minDec - минимально значение не котрое надо уменьшить
			при $pct = 0 не срабатывает
		$minVal - минимально значение которое может получится
	[eg web/test/web/css/pcss/dec.php]

		//как будто minCeil - не на своём месте / никто не пользуеться
*/
function _dec($val, $pct = true, $minCeil = true, $minDec = true, $minVal = true){
	if ($pct === true) $pct = 0.001;
	if ($minCeil === true) $minCeil = .5;
	if ($minDec === true) $minDec = 1;
	if ($minVal === true) $minVal = 0;
	$pct = (float) $pct;

	//d($pct);
	if ($pct > 0) {
		$dec = ($pct / 100) * $val;
		$leftover = $dec - floor($dec);
		//dx($val, ($pct / 100) * $val, $leftover, ceil($dec), floor($dec), ($leftover > $minCeil ? ceil($dec) : floor($dec)), $minDec);
		$dec = $leftover > $minCeil ? ceil($dec) : floor($dec);
		if ($minDec && ($minDec > $dec)) $dec = $minDec;
	} else {
		$dec = 0;
	}

	$res = $val - $dec;
	return $res < $minVal ? $minVal : $res;
}

function _rdec(&$val, $pct = 0, $minCeil = true, $minDec = true){
	return $val = _dec($val, $pct, $minCeil, $minDec);
}

//создание набора данных
function dec_($value, $decData){
	$val_ = array();
	if (is_array($decData)) foreach ($decData as $index => $decRule) {
		$_val = $decRule; //norm case: is_null_or_false($decRule) / string / obj / …
		if (is_true($decRule)) {
			$_val = $value;
		} elseif (is_number($decRule)) {
			$_val = _dec($value, $decRule);
		}
		$val_[$index] = $_val;
	}
	return $val_;
}