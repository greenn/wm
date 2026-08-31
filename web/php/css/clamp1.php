<?#3.2.1
_needphp('css/vu');
//_needphp('fq/parseUnitValue');

/*
 	arg1 - ставим текуще значение
	arg2 - до какого значения оно меняется (можно true)
	arg3 -' от него отсчитываем min
	arg4 -'

	font-size: <?=_clampFactor(-20, 20, 10)?>; //замедление изменения на 20%

	margin: 0 <?=_clamp(47, 10)?>;
    margin: 0 <?=_clampFactor(30, 47, 10)?>; //ускорение изменения на 30%
    margin: 0 <?=_clamp([47, -30], 10)?>;

	$mqMin - Нужен только если $minValue высчитывается автоматическ

	[oo .d/]
		v3 - учитывает отоносительное изменение c $mqMax по $mqMin
*/
function _clamp($value, $minValue = true, $mqMax = true, $mqMin = true, $unit = true) {
	if ($mqMax === true) $mqMax = 1200;
	if ($mqMin === true) $mqMin = 500;
	if ($unit === true) $unit = array('px', 'px');

	$factor = 1; //коэффициент замедление
	if (is_array($value)) {
		list($value, $factor) = $value;
	}

	$precision = 3;
	if (is_array($mqMax)) {
		list($mqMax, $precision) = $mqMax;
	}

	//list($value, $valueUnit) = parseUnitValue($minValue, 'px');

	if ($minValue === true) {
		$minValue = round($value * ($mqMin / $mqMax));
	}

	//list($minValue, $minValueUnit) = parseUnitValue($minValue, 'px');

	$rel = _vu($value, $mqMax, $precision);
	if ($factor !== 1) {
		if (abs($factor) > 1) { //case: значение $factor переданно в процентах
			$factor = $factor / 100;
		}
		$rel *= (1 - $factor);
	}


	list($valueUnit, $minValueUnit) = is_array($unit) ? $unit : array($unit, $unit);
	return "clamp({$minValue}{$minValueUnit}, {$rel}vw, {$value}{$valueUnit})";
}

function _clampFactor($factor, $value, $minValue = true, $mqMax = true, $mqMin = true, $unit = true){
	return _clamp(array($value, $factor), $minValue, $mqMax, $mqMin, $unit);
}

function _clampPct($value, $minValue = true, $mqMax = true, $mqMin = true){
	return _clamp($value, $minValue, $mqMax, $mqMin, '%');
}
function _clampFactorPct($factor, $value, $minValue = true, $mqMax = true, $mqMin = true){
	return _clampFactor($factor, $value, $minValue, $mqMax, $mqMin, '%');
}