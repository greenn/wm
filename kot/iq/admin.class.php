<?#3.7.0 - new custom class


class _cssAdmin extends _css {
	static $db = array(); //своя база
}

function _cssAdmin($name){
	$arg = func_num_args() > 1 ? func_get_args() : $name;
	return _cssAdmin::val($arg);
}

class admin extends rt {
	static $rClass = 'admin';

	//01
	static $temp;
	static $vtpl = false;
	static $vdef = 0;
	static $vname = array();

	static function nc($name = true, $subName = false, $usePrefix = true){
		$n = parent::nc($name, $subName, false);
		return $usePrefix ? 'a'.$n : $n; //return $n;
	}
}

//менеджер по работе с admin классом
class _admin extends _rt {
	static $rClass = 'admin';
	static $db = array(); //своя база
	static $cache = array(); //свой cache

	static function rDir(){
		return ROOT.'/r/admin';
		//return ROOT.'/admin/pik';
		//return ROOT.'/kot/r/pik';
	}

	static function className($name){
		return "admin_$name";
	}
}


function admin($name, $method = null/*, $arg1, $arg2*/){
	return _r_('admin', func_get_args());
}

function admin_tpl($name, $tplName = true, $tplCtx = false, $fileExt = 'tpl.php', $method = 'tpl'){
	return _r_tpl('admin', func_get_args());
}

function admin_tpl_($Args) {
	return call_user_func_array('admin_tpl', (array)$Args);
}

function admin_vtpl($name, $tplName = true, $tplCtx = false, $fileExt = 'tpl.php'){
	return admin_tpl($name, $tplName, $tplCtx, $fileExt, 'vtpl');
}



_rt::req('api');

/*
	ug
		api_admin('side-menu/list', array('by' => 'link'))
	    api_admin('targets/list')
	    admin_api::get_prop('list', 'targets/list')
*/
function api_admin(/*$method,*/ $requestUri, $data = array()){
	$method = 'get';
	if (func_num_args() === 3) {
		list($method, $requestUri, $data) = func_get_args();
	}
	if (is_array($requestUri)) {
		list($method, $requestUri) = $requestUri;
	}
	return rt_api::request($requestUri, $data, $method, $r = 'admin');
}



class admin_api extends _api {
	static $r = 'admin';

	static $dbg = false;
	static $dbgApi = true;
	static $dbgMe = true;
	static $dbgGet = true;
}


class admin_i extends _img { //admin_i|i_admin
	static $dir = 'i/admin';
	//static $skipHostVerify = true;
}