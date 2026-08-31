<?#3.1.0
_needphp('css/vu');
//_needphp('fq/parseUnitValue');

/*

	font-size: <?=_clampFactor(-20, 20, 10)?>; //замедление изменения на 20%

	margin: 0 <?=_clamp(47, 10)?>;
    margin: 0 <?=_clampFactor(30, 47, 10)?>; //ускорение изменения на 30%
    margin: 0 <?=_clamp([47, -30], 10)?>;

	$mqMin - Нужен только если $minValue высчитывается автоматическ
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

	if (is_number($mqMin)) {
		if (abs($factor) < 1) {
			$factor *= 100;
		}

		$rel = calculateRelativeScale(array(
			'currentValue' => $minValue,
			'minValue' => $mqMin,
			'maxValue' => $mqMax,
			'minScale' => $minValue,
			'maxScale' => $value,
			'roundResult' => $precision
		));

		$rel = calculateVWWithFactor($minValue, $value, $mqMin, $mqMax, $factor);

	} else {
		//base v2 case
		$rel = _vu($value, $mqMax, $precision);
		if ($factor !== 1) {
			if (abs($factor) > 1) { //case: значение $factor переданно в процентах
				$factor = $factor / 100;
			}
			$rel *= (1 - $factor);
		}
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


//Claude 3.5 Sonnet
//https://claude.ai/chat/bfe11b72-dd9c-44cb-a092-38b4b085a3e5

function calculateRelativeScale($params) {
	// Устанавливаем значения по умолчанию
	$defaults = [
		'currentValue' => 0,
		'minValue' => 0,
		'maxValue' => 1,
		'minScale' => 0,
		'maxScale' => 1,
		'roundResult' => true
	];

	// Объединяем переданные параметры со значениями по умолчанию
	$params = array_merge($defaults, $params);

	// Извлекаем параметры в переменные
	extract($params);

	// Вычисляем процент от диапазона
	$ratio = ($currentValue - $minValue) / ($maxValue - $minValue);

	// Вычисляем масштаб в заданном диапазоне
	$scale = $minScale + ($ratio * ($maxScale - $minScale));

	// Ограничиваем значение
	$clampedScale = max($minScale, min($maxScale, $scale));

	// Возвращаем округленное или точное значение
	return $roundResult ? (int) round($clampedScale) : $clampedScale;
}

/**
 * Расширенная функция с поддержкой фактора скорости изменения
 */
function calculateFactoredScale($params) {
	// Устанавливаем значения по умолчанию
	$defaults = [
		'currentValue' => 0,
		'minValue' => 0,
		'maxValue' => 1,
		'minScale' => 0,
		'maxScale' => 1,
		'factor' => 0,
		'roundResult' => true
	];

	// Объединяем переданные параметры со значениями по умолчанию
	$params = array_merge($defaults, $params);

	// Извлекаем параметры в переменные
	extract($params);

	// Вычисляем базовый процент от диапазона
	$ratio = ($currentValue - $minValue) / ($maxValue - $minValue);

	// Применяем фактор к соотношению
	$adjustedRatio = $ratio;
	if ($factor !== 0) {
		$factorMultiplier = 1 + ($factor / 100);
		// Используем pow для создания нелинейной кривой
		$adjustedRatio = pow($ratio, $factorMultiplier);
	}

	// Вычисляем масштаб в заданном диапазоне с учётом фактора
	$scale = $minScale + ($adjustedRatio * ($maxScale - $minScale));

	// Ограничиваем значение
	$clampedScale = max($minScale, min($maxScale, $scale));

	// Возвращаем округленное или точное значение
	return $roundResult ? (int) round($clampedScale) : $clampedScale;
}


//ChatGPT-4 Turbo
//https://chatgpt.com/c/678e0841-7b8c-8008-b03b-e9a242404576
function calculateVW($minValue, $maxValue, $minWidth, $maxWidth) {
	// Рассчитываем коэффициент изменения
	$vw = ($maxValue - $minValue) / ($maxWidth - $minWidth) * 100;
	return round($vw, 2); // Округляем до двух знаков
}

function calculateVWWithFactor($minValue, $maxValue, $minWidth, $maxWidth, $factorPercentage) {
	// Рассчитываем стандартный vw
	$vw = ($maxValue - $minValue) / ($maxWidth - $minWidth) * 100;

	// Рассчитываем фактор (например, -30% → 0.7, +30% → 1.3)
	$factor = 1 + ($factorPercentage / 100);

	// Применяем фактор к vw
	$adjustedVW = $vw * $factor;

	return round($adjustedVW, 2); // Округляем до двух знаков
}