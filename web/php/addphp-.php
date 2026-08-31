<?#2.6.1
# [oo] php/need.php
# [eg] web/test/web/php/addphp.php

if (!isset($GLOBALS['_webphpList'])) { //[rb VAR_INCLUDED_LIST]
	$GLOBALS['_webphpList'] = array(
		'addphp' => PHP.'/addphp.php'
	);
}
if (!isset($GLOBALS['_webphpOrder'])) { //[rb VAR_INCLUDED_ORDER]
	$GLOBALS['_webphpOrder'] = array('addphp');
}

function addphp($phpName){
    //_notch();
	$operationResult = 0;

	if (is_string($phpName)) {
		if (!isset($GLOBALS['_webphpList'][$phpName])) {  //|_webOnceIncludedPhp|

			$phpIncludePath = PHP.'/'.$phpName.'.php';

			if (is_file($phpIncludePath)) {

				include_once($phpIncludePath);

				$GLOBALS['_webphpList'][$phpName] = $phpIncludePath;
				$operationResult = 1; //первый раз
			}

		} else {
			$operationResult = 2; //второй раз
		}

		$GLOBALS['_webphpOrder'] []= "$phpName/$operationResult";
	}



    //_notch('+'.$phpName);
	return $operationResult;

}



/*
add
	version prm

names
	incphp

	usephp +



*/