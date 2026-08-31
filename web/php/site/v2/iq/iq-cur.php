<?#1.3.1

/*_needphp(
	'site/v2/iq/iq-site',
	'site/v2/iq/iq-pro',
);*/

//вызов метода или получение данных от текущего проекта или сайта
function cur(){
	$callArgs = func_get_args();
	return _cur_($callArgs);
}

//оператор вызов метода или получение данных от текущего проекта или сайта
function _cur_($callArgs, $proSid = true, $siteSid = true){
	$res = _pro_($proSid, $callArgs);
	if ($res === null) {
		$res = _site_($siteSid, $callArgs);
	}
	return $res;
}

/*
	_pro()
	cur_pro()
*/

