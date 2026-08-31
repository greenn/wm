<?#2.0

/*
	выбор аргумент по индексу
	[eg] web/test/web/inc/cbn.php

*/

_addphp('fq/_is'); // is_stringable

//выбора из массива
//[ud] web/dev/uf/pl/decl.json.php
//аналогично работает в данной ситуации prop()
function sArr($arr, $index, $otherwise = false){ return (is_array($arr) && is_stringable($index) && isset($arr[$index])) ? $arr[$index] : $otherwise; }

//выбора из пришедших аргументов
//выбор из списка аргументов, последним аргументом как индекс
//[ud] web/inc/css/cbn.php
function csArg($cArgs = array()){ return call_user_func_array('sArg', $cArgs); }
function sArg(){ //[wttg]
	$args = func_get_args();
	$argsN = count($args);
	$value = $argsN > 0 ? $args[0] : false;
	if ($argsN > 1) {
		$selecterIndex = $argsN - 1;
		$select = $args[$selecterIndex];
		if (is_numeric($select) && ($select !== $selecterIndex) && isset($args[$select])) {
			$value = $args[$select];
		}
	}
	return $value;
}