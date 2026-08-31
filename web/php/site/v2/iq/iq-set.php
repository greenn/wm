<?#1.3.0


//получение set-данные от текущего проекта-и-сайта

function cur_set(){
	$callArgs = func_get_args();
	return _set_($callArgs, true, true);
}



//получение set-данные от указанного проекта-и-сайта
function _set($proSid/*, $args */){
	$callArgs = array_slice(func_get_args(), 1);
	return _set_($callArgs, $proSid, true);
}

//получение set-данные только от указанного проекта
function _setPro($proSid/*, $args */){
	$callArgs = array_slice(func_get_args(), 1);
	return _set_($callArgs, $proSid, false);
}

//получение set-данные только от указанного сайта
function _setSite($siteSid/*, $args */){
	$callArgs = array_slice(func_get_args(), 1);
	return _set_($callArgs, false, $siteSid);
}


//оператор получения set-данных от проекта-или-сайта (по умолчанию - текущего)
function _set_($callArgs, $proSid = true, $siteSid = true){
	$proHasSet = _pro($proSid, 'setHas', $callArgs);
	if ($proHasSet) {
		return _pro($proSid, 'setGet', $callArgs);
	} else {
		return _site($siteSid, 'setGet', $callArgs);
	}
}

/*
	_pro()
	cur_pro()
*/