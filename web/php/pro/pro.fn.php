<?#0.5.5

//получение данных из pro
function pro(/*cfgProp, cfgSubProp*/){
	return call_user_func_array("pro::cfg_get", func_get_args());
}

//сладкий pro_data
/*
	_pro('app-title')
	ak pro('data', 'app-title')
*/
function _pro(/*dataProp, dataSubProp*/){
	$args = func_get_args();
	array_unshift($args, 'data');
	return call_user_func_array("pro", $args);
}

