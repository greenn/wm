<?#3.7.0 - new custom class


class kmod extends rt {
	static $rClass = 'kmod';

	//01
	static $temp;
	static $vtpl = false;
	static $vdef = 0;
	static $vname = array();

	static function nc($name = true, $subName = false, $usePrefix = true){
		$n = parent::nc($name, $subName, false);
		return $usePrefix ? 'ap'.$n : $n; //return $n;
	}
}

//менеджер по работе с kmod классом
class _kmod extends _rt {
	static $rClass = 'kmod';
	static $db = array(); //своя база
	static $cache = array(); //свой cache

	static function rDir(){
		return ROOT.'/kot/r/mod';
	}

	static function className($name){
		return "kmod_$name";
	}
}


function kmod($name, $method = null/*, $arg1, $arg2*/){
	return _r_('kmod', func_get_args());
}

function kmod_tpl($name, $tplName = true, $tplCtx = false, $fileExt = 'tpl.php', $method = 'tpl'){
	return _r_tpl('kmod', func_get_args());
}

function kmod_tpl_($Args) {
	return call_user_func_array('kmod_tpl', (array)$Args);
}

function kmod_vtpl($name, $tplName = true, $tplCtx = false, $fileExt = 'tpl.php'){
	return kmod_tpl($name, $tplName, $tplCtx, $fileExt, 'vtpl');
}



_rt::req('api');

/*
	ug
		api_kmod('side-menu/list', array('by' => 'link'))
	    api_kmod('targets/list')
	    kmod_api::get_prop('list', 'targets/list')
*/
function api_kmod(/*$method,*/ $requestUri, $data = array()){
	$method = 'get';
	if (func_num_args() === 3) {
		list($method, $requestUri, $data) = func_get_args();
	}
	if (is_array($requestUri)) {
		list($method, $requestUri) = $requestUri;
	}
	return rt_api::request($requestUri, $data, $method, $r = 'kmod');
}



class kmod_api extends _api {
	static $r = 'kmod';

	static $dbg = false;
	static $dbgApi = true;
	static $dbgMe = true;
	static $dbgGet = true;
}
