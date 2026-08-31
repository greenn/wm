<?#4.2.3
_needphp('css/vu');


# https://chatgpt.com/c/67fb9df9-0688-8008-949d-9bca2650a6be

function _clamp2($startValue, $endValue, $mqMax = 1400, $mqMin = 360, $unit = true) {
	$range = $mqMax - $mqMin;
	if ($range === 0) return "{$startValue}{$unit}"; // избежать деления на 0

	$isIncreasing = $endValue > $startValue;
	$delta = abs($endValue - $startValue);
	$coef = round($delta / $range, 5);

	if ($unit === true) $unit = array('px', 'px');
	list($endValueUnit, $startValueUnit) = is_array($unit) ? $unit : array($unit, $unit);

	$start = "{$startValue}{$startValueUnit}";
	$end = "{$endValue}{$endValueUnit}";
	$mqMinVal = "{$mqMin}px";

	//case base: уменьшение значения с уменьшением экрана
	$minClamp = $end;
	$maxClamp = $start;

	if ($isIncreasing) {
		//case: увеличение значения с уменьшением экрана
		$coef = $coef * (-1);
		$minClamp = $start;
		$maxClamp = $end;
	}

	//clamp(MIN, PREFERRED, MAX)
	return "clamp($minClamp, calc($end + (100vw - $mqMinVal) * " . $coef . "), $maxClamp)";
}