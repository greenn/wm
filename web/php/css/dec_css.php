<?#1.0.1
_needphp(
	'pcss',
	'css/dec'
);

//[eg web/test/web/inc/css/dec_css.php]
function dec_css($Sr, $Conf, $Dec = array(), $Env = false){
	/*
		$Sr - css-селектор для данного правила
		$Conf - список сввойств, заданных с возможными указаниями
	    $Dec - (конифигурация) указания уменьшения
			число - одно значение для всех
			массив - список про именнованных указания
		$Env - конфиг окружения //0
			unit - defUnit
			detailedInfo - тип доп. информации рядом со свойством с уменьшиным значением

		$dec - процент уменьшения
	*/

	if ($Env === true) {
		$Env = array(
			'detailedInfo' => true
		);
	}

	//dx(pcss($conf));

	//step: парсим данные
	$propsConf = array();
	foreach ($Conf as $prop => $value) {
		$_flag = '(\#)?';                       //1: skipFlag
		$_base = '([^([:]+)';                   //2: prop
		$_square  = '(?:'.'\[([^]]+)\]'.')?';   //3: [pos/pattern]
		$_round  = '(?:'.'\(([^)]+)\)'.')?';    //4: (units)
		$_dec  = '\:(.+)';                      //5: :dec
		$_dec = "(?:$_dec)?";
		//https://regex101.com/r/0X9cho/3 (z4 er in base)
		//https://regex101.com/r/0X9cho/5
		$rega = '~^'.$_flag.$_base.$_square.$_round.$_dec.'$~';

		$skipFlag = false;
		$posConf = false;
		$unitConf = false;
		$decConf = false;
		if (preg_match_all($rega, $prop, $propConf)) {
			//dx($propConf);
			$skipFlag = $propConf[1][0];
			$prop = $propConf[2][0];
			$posConf = $propConf[3][0];
			$unitConf = $propConf[4][0];
			$decConf = $propConf[5][0];
		}
		//dx($skipFlag, $prop, $value, $decConf, $unitConf, $posConf);

		if (!is_array($value)) $value = explode('/', $value);
		$decConf = explode('/', $decConf);
		$unitConf = explode('/', $unitConf);
		$posConf = explode('/', $posConf);

		$propsConf[$prop] = array($skipFlag, $value, $decConf, $unitConf, $posConf);
	}
	//dx($propsConf);

	//step: аккамулируем данные / готовим стек для pcss
	$propsData = array();
	$defUnit = prop($Env, 'unit', 'px');
	$detailedInfo = prop($Env, 'detailedInfo');

	$_decVals = array();
	//$defDec = 0;
	$defDec = is_array($Dec) ? prop($Dec, ':', false) : (is_numeric($Dec) ? $Dec : false);
	foreach ($propsConf as $prop => $conf) {
		list($skipFlag, $_data, $_dec, $_unit, $_pos) = $conf;
		//dx($_dec, $_data, $_unit, $_pos);

		//step: формирование dec-значений
		$values = [];
		$info = [];
		$curDefDec = $defDec; //false|decValue|decName|%prevDecValue
		foreach ($_data as $index => $_value) {

			if ($skipFlag) {
				$values []= $_value;
				$info []= '';
			} else {

				$dec = $decSet = prop($_dec, $index); //case decValue: {%prop:%value}
				if (!is_numeric($dec)) $dec = prop($Dec, $dec, $curDefDec); //case decName: {%prop:%name}, где значение в $Dec(%name => %value)
				if (is_false($curDefDec)) $curDefDec = $dec;

				if (is_false($dec)) $dec = 0;

				$newValue = _dec($_value, $dec);
				$_decVals []= $newValue;
				//dx($newValue);

				$_info = $_value;
				if ($detailedInfo) {
					//$_info  = "$_value:$decSet";
					//$_info = "$_value:$decSet($dec)";
					$_info = "$_value:$dec($decSet)";
				}

				$values []= $newValue;
				$info []= $_info;
			}
		}
		//dx($values);

		//step: формирование unit-значений
		$curDefUnit = false; //[z4] сразу не ровняем к $defUnit, т.к. Первый $unit может быть отличным, а нам хочеться его продлить дальше
		foreach ($values as $index => $_value) {
			if ($skipFlag) {
				//ничего не делаем
			} else {
				$unit = prop($_unit, $index);
				if (!$unit) $unit = $curDefUnit ? $curDefUnit : $defUnit;
				if (!$curDefUnit) $curDefUnit = $unit;
				$values[$index] = $_value.$unit;
			}
		}
		//dx($values);
		
		//step: формирование паттерна для значение
		$pattern = true;
		//вариант использования $_pos


		//step: получение строковго значения на основе данных
		if ($pattern === true) {

			$value = join(space, $values);

		} else {
			$value = var_export($values);
		}
		/* else {
			$args = is_array($_value) ? $_value : array($_value);
			array_unshift($args, $pattern);
			$value = call_user_func_array('sprintf', $args);
		}*/

		//dx($_data, $value, $pattern);


		$propsData[$prop] = array($value, $skipFlag ? null : $info);
	}
	//dx($propsData);

	$N = newline;
	$T = str_repeat(space, 4);

	//step: формирование dec-легенды
	$legend = '';
	if (prop($Env, 'legend')) {
		if (is_array($Dec)) {
			$legend = array();
			foreach ($Dec as $id => $pct) {
				$legend []= "$id: $pct%";
			}
			$legend = join(', ', $legend);
		} else {
			$legend = "$Dec%";
		}

		$legend = "/*dec($legend)*/";
	}


	//step: формирование списка css-свойств
	$props = array();
	foreach ($propsData as $propName => $conf) {
		list($value, $baseValue) = $conf;
		$prop = pcss($propName, $value);

		if ($skipFlag = $baseValue === null) {
			$props []= $prop;
		} else {
			$base = is_array($baseValue) ? join(space, $baseValue) : $baseValue;
			$props []= "/*$base*/ $prop";
		}
	}
	$props = $T.join($N.$T, $props);

	//step: формирование результирующей css-конструкции
	$css = $T.$legend.$N.$props;

	if (is_array($Sr)) $Sr = join(', ', $Sr);
	if ($Sr) {
		$css = sprintf('%s {'.$N.'%s'.$N.'}'.$N, $Sr, $css);
	}

	x(XN_LAST_DEC_CSS_VALS, $_decVals);
	return $css;
}



function dec_css_if($cond){
	if ($cond) {
		$args = array_slice(func_get_args(), 1);
		return call_user_func_array('dec_css', $args);
	} else {
		return '';
	}
}

//комментатор / нейтролизатор
function _dec_css(){ return ''; }
function _dec_css_if(){ return ''; }

function _decMin($minVal, $val, $pct = true, $minDec = true, $minCeil = true){
	return _dec($val, $pct, $minDec, $minCeil, $minVal);
}

function dec_css_legend($Dec){
	return dec_css(false, array(), $Dec, array('legend' => true));
}
/*
	доступ к посчитынным данным в послелнем вызове dec_css();
	eg:
		dec_css(…)
		_dec_css_vals(1,2) - массив из двух элементов, соджержащий второе и третье новое посчитанное значение в dec_css
*/
function _dec_css_vals(/*indexes*/){
	$data = x(XN_LAST_DEC_CSS_VALS);
	if ($args = func_get_args()) {
		$data = array_pick($data, $args);
	}
	return $data;
}
function _dec_css_val($index = 0){
	//return _dec_css_vals($index)[0];
	return x_prop(XN_LAST_DEC_CSS_VALS, $index);

}