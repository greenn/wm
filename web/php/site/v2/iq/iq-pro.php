<?#1.6.0

//вызов метода или получение данных от текущего проекта
//ak cur_pro
function pro(){
	$args = func_get_args();
	array_unshift($args, true);
	return call_user_func_array('_pro', $args);
}

//вызов метода или получение данных от указанного проекта
function _pro($proSid/*, $args */){
	$callArgs = array_slice(func_get_args(), 1);
	return _pro_($proSid, $callArgs);
}

//оператор вызов метода или получение данных от указанного проекта
function _pro_($proSid, $callArgs){
	return _iq::call_proArgs($proSid, $callArgs);
}


function css(...$args){
	array_unshift($args, 'css');
	return _pro_(true, $args);
}

//L для site/v1 функциональности
//allias для текущей (site/v2) css()
function _css(...$args){
	array_unshift($args, 'css');
	return _pro_(true, $args);
}

function _cssPro($proSid, ...$args){
	array_unshift($args, 'css');
	return _pro_($proSid, $args);
}

function i(...$args){
	array_unshift($args, 'i');
	return _pro_(true, $args);
}

function _i($proSid, ...$args){
	array_unshift($args, 'i');
	return _pro_($proSid, $args);
}