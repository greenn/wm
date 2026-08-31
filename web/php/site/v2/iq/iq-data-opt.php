<?#2.1.0


//получение opt-данных (settings) от текущего проекта-или-сайта
function data_opt(){
	$callArgs = func_get_args();
	return _dataOpt_($callArgs, true, true);
}

//получение data-данные от указанного проекта-и-сайта
function _dataOpt($proSid/*, $args */){
	$callArgs = array_slice(func_get_args(), 1);
	return _dataOpt_($callArgs, $proSid, true);
}

//получение data-данные только от указанного проекта
function _dataOptPro($proSid/*, $args */){
	$callArgs = array_slice(func_get_args(), 1);
	return _dataOpt_($callArgs, $proSid, false);
}

//получение data-данные только от указанного сайта
function _dataOptSite($siteSid/*, $args */){
	$callArgs = array_slice(func_get_args(), 1);
	return _dataOpt_($callArgs, false, $siteSid);
}


//оператор получения data-данных от текущего проекта-и-сайта
function _dataOpt_($callArgs, $proSid = true, $siteSid = true){
	$proHasData = _pro($proSid, 'dataOptHas', $callArgs);
	if ($proHasData) {
		return _pro($proSid, 'dataOptGet', $callArgs);
	} else {
		return _site($siteSid, 'dataOptGet', $callArgs);
	}
}

/*
	_pro()
	cur_pro()
*/