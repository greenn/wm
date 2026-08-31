<?#4.4.1(ripr) - ripr resources plus

class _cssRipr extends _css {
	static $db = array(); //своя база
}

function _cssRipr($name){
	$arg = func_num_args() > 1 ? func_get_args() : $name;
	return _cssRipr::val($arg);
}


class ripr extends rt {
	static $rClass = 'ripr';
	static $temp; //01

	static $vtpl = false;
	static $vdef = 0;
	static $vname = array();


#= extend-update
	static function nc($name = true, $subName = false, $usePrefix = true){
		$n = parent::nc($name, $subName, false);
		//return $usePrefix ? 'st'.$n : $n;
		return $n;
	}
#\

}

//менеджер по работе с ripr классом
class _ripr extends _rt {
	static $rClass = 'ripr';
	static $db = array(); //своя база
	static $cache = array(); //свой cache

	static function rDir(){
		return ROOT.'/ripr/r';
	}

	static function className($name){
		return "ripr_$name";
	}
}


function ripr($name, $method = null/*, $arg1, $arg2*/){
	return _r_('ripr', func_get_args());
}

function ripr_tpl($name, $tplName = true, $tplCtx = false, $fileExt = 'tpl.php', $method = 'tpl'){
	//return _r_tpl('ripr', func_get_args());
	if ($tplName === true) {
		//case: ripr_tpl($name)
		$tplName = $name;
	}
	$args = array($name, $method, $tplName, $tplCtx, $fileExt);
	if (func_num_args() > 5) {
		//case spec: есть дополнительные аргументы
		$extraArgs = array_slice(func_get_args(), 5);
		$args = array_merge($args, $extraArgs);
	}
	//d('ripr_tpl', $name, $tplName, $tplCtx, $fileExt, @$extraArgs);
	return call_user_func_array('ripr', $args);
	//[vp1] return ripr($name, $method, $tplName, $tplCtx, $fileExt);
}

function ripr_tpl_($Args) {
	return call_user_func_array('ripr_tpl', (array)$Args);
}


_rt::req('api');

/*
	ug
		api_kmod('side-menu/list', array('by' => 'link'))
	    api_kmod('targets/list')
	    kmod_api::get_prop('list', 'targets/list')
*/
function api_ripr(/*$method,*/ $requestUri, $data = array()){
	$method = 'get';
	if (func_num_args() === 3) {
		list($method, $requestUri, $data) = func_get_args();
	}
	if (is_array($requestUri)) {
		list($method, $requestUri) = $requestUri;
	}
	return rt_api::request($requestUri, $data, $method, $r = 'ripr');
}



class ripr_api extends _api {
	static $r = 'ripr';

	static $dbg = false;
	static $dbgApi = true;
	static $dbgMe = true;
	static $dbgGet = true;
}


class ripr_i extends _img {
	static $dir = 'ripr/i';
	//static $skipHostVerify = true;
}

//dx(class_exists('ripr_i'));