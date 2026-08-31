<?#3.1.0


//получение opt-данные (opttings/opt) от текущего проекта-и-сайта
function cur_opt(...$callArgs){
	return _opt_($callArgs, true, true);
}



//получение установок (options) от текущего сайта
function site_opt(...$callArgs){
	return _site(true, 'optGet', $callArgs);
}

//получение установок (options) от текущего проекта
function pro_opt(...$callArgs){
	return _pro(true, 'optGet', $callArgs);
}

function _proOpt($proSid, ...$callArgs){
	return _pro($proSid, 'optGet', $callArgs);
}



function _proOptEnv($proSid, $envName){
	$value = _proOpt($proSid, 'env', $envName);
	if (isOrdinal($value)) $value = $value[0]; //case: as quick-defined-className
	return $value;
}
function pro_opt_env($envName){
	return _proOptEnv(true, $envName);
}


//оператор получения set-данных от проекта-или-сайта (по умолчанию - текущего)
function _opt_($callArgs, $proSid = true, $siteSid = true){
	$proHasOpt = _pro($proSid, 'optHas', $callArgs);
	if ($proHasOpt) {
		return _pro($proSid, 'optGet', $callArgs);
	} else {
		return _site($siteSid, 'optGet', $callArgs);
	}
}


