<?#3.7.0 - new custom class


class _cssPik extends _css {
	static $db = array(); //своя база
}

function _cssPik($name){
	$arg = func_num_args() > 1 ? func_get_args() : $name;
	return _cssPik::val($arg);
}

class pik extends rt {
	static $rClass = 'pik';

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

//менеджер по работе с pik классом
class _pik extends _rt {
	static $rClass = 'pik';
	static $db = array(); //своя база
	static $cache = array(); //свой cache

	static function rDir(){
		return ROOT.'/r/admin';
		//return ROOT.'/admin/pik';
		//return ROOT.'/kot/r/pik';
	}

	static function className($name){
		return "pik_$name";
	}
}


function pik($name, $method = null/*, $arg1, $arg2*/){
	return _r_('pik', func_get_args());
}

function pik_tpl($name, $tplName = true, $tplCtx = false, $fileExt = 'tpl.php', $method = 'tpl'){
	return _r_tpl('pik', func_get_args());
}

function pik_tpl_($Args) {
	return call_user_func_array('pik_tpl', (array)$Args);
}

function pik_vtpl($name, $tplName = true, $tplCtx = false, $fileExt = 'tpl.php'){
	return pik_tpl($name, $tplName, $tplCtx, $fileExt, 'vtpl');
}



_rt::req('api');

/*
	ug
		api_pik('side-menu/list', array('by' => 'link'))
	    api_pik('targets/list')
	    pik_api::get_prop('list', 'targets/list')
*/
function api_pik(/*$method,*/ $requestUri, $data = array()){
	$method = 'get';
	if (func_num_args() === 3) {
		list($method, $requestUri, $data) = func_get_args();
	}
	if (is_array($requestUri)) {
		list($method, $requestUri) = $requestUri;
	}
	return rt_api::request($requestUri, $data, $method, $r = 'pik');
}



class pik_api extends _api {
	static $r = 'pik';

	static $dbg = false;
	static $dbgApi = true;
	static $dbgMe = true;
	static $dbgGet = true;
}


class pik_i extends _img { //pik_i|i_pik
	static $dir = 'admin/img';
	//static $skipHostVerify = true;
}