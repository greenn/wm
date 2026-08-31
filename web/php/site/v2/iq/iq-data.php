<?#1.2.0


//получение data-данные от текущего проекта-и-сайта
function data(){
	$callArgs = func_get_args();
	return _data_($callArgs, true, true);
}

//получение data-данные от указанного проекта-и-сайта
function _data($proSid/*, $args */){
	$callArgs = array_slice(func_get_args(), 1);
	return _data_($callArgs, $proSid, true);
}

//получение data-данные только от указанного проекта
function _dataPro($proSid/*, $args */){
	$callArgs = array_slice(func_get_args(), 1);
	return _data_($callArgs, $proSid, false);
}

//получение data-данные только от указанного сайта
function _dataSite($siteSid/*, $args */){
	$callArgs = array_slice(func_get_args(), 1);
	return _data_($callArgs, false, $siteSid);
}


//оператор получения data-данных от текущего проекта-и-сайта
function _data_($callArgs, $proSid = true, $siteSid = true){
	if (!$callArgs) {
		$proData = pro('getData');
		$siteData = site('getData');
		//dx($proData, $siteData);
		$resData = $proData ?: array();
		if ($siteData) $resData = array_replace_recursive($resData, $siteData);
		return $resData;
	}

	$proHasData = _pro($proSid, 'dataHas', $callArgs);
	if ($proHasData) {
		return _pro($proSid, 'dataGet', $callArgs);
	} else {
		return _site($siteSid, 'dataGet', $callArgs);
	}
}

/*
	_pro()
	cur_pro()
*/