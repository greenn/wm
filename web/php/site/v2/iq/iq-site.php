<?#1.2.5

//вызов метода или получение данных от текущего сайта
//ak cur_site
function site(){
	$args = func_get_args();
	array_unshift($args, true);
	return call_user_func_array('_site', $args);
}

//вызов метода или получение данных от указанного сайта
function _site($siteSid/*, $args */){
	$callArgs = array_slice(func_get_args(), 1);
	return _site_($siteSid, $callArgs);
}

//опертор вызов метода или получение данных от указанного сайта
function _site_($siteSid, $callArgs){
	return _iq::call_siteArgs($siteSid, $callArgs);
	//dx('_site_', $siteSid, $callArgs, _iq::call_siteArgs($siteSid, $callArgs));
	//$res = _iq::call_siteArgs($siteSid, $callArgs); d($res->rootDir);  return $res;
}

