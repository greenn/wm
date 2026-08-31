<?#3.1.0 - new custom class


_needphp('str/startsWith');

class metro extends rt {
	static $rClass = 'metro';
	
	//01
		static $temp;
		static $vtpl = false;
		static $vdef = 0;
		static $vname = array();

	static function nc($name = true, $subName = false, $usePrefix = true){
		$n = parent::nc($name, $subName, false);
		//return $usePrefix ? 'm'.$n : $n;
		return $n;
	}
}

//менеджер по работе с metro классом
class _metro extends _rt {
	static $rClass = 'metro';
	static $db = array(); //своя база
	static $cache = array(); //свой cache

	static function rDir(){
		return ROOT.'/kot/r/metro';
	}

	static function className($name){
		return "metro_$name";
	}


	static function namedUrl($title, $addUri = ''){
		static $menuData = array(); //$menuListByTitle
		if (!$menuData) {
			$menuData = metro_api::get_prop('list', 'side-menu/list', array('by' => 'name'));
		}
		$item = prop($menuData, $title);
		$resLink = prop($item, 'link');
		if ($addUri) {
			$resLink = rtrim($resLink, '/').'/'.ltrim($addUri , '/');
		}
		return '/'.ltrim($resLink, '/');
	}
}


function metro($name, $method = null/*, $arg1, $arg2*/){
	return _r_('metro', func_get_args());
}

function metro_tpl($name, $tplName = true, $tplCtx = false, $fileExt = 'tpl.php', $method = 'tpl'){
	return _r_tpl('metro', func_get_args());
	/*if (is_array($tplName)) {
		//case: metro_tpl($name, $tplCtx)
		$tplCtx = $tplName;
		$tplName = true;
	}
	if ($tplName === true) {
		//case: metro_tpl($name)
		$tplName = $name;
	}
	//d($name, $tplName, $tplCtx, $fileExt);
	return metro($name, $method, $tplName, $tplCtx, $fileExt);*/
}

function metro_tpl_($Args) {
	return call_user_func_array('metro_tpl', (array)$Args);
}

function metro_vtpl($name, $tplName = true, $tplCtx = false, $fileExt = 'tpl.php'){
	return metro_tpl($name, $tplName, $tplCtx, $fileExt, 'vtpl');
}

/*
	ug
		api_metro('side-menu/list', array('by' => 'link'))
	    api_metro('targets/list')
	    metro_api::get_prop('list', 'targets/list')
*/
function api_metro(/*$method,*/ $requestUri, $data = array()){
	$method = 'get';
	if (func_num_args() === 3) {
		list($method, $requestUri, $data) = func_get_args();
	}
	if (is_array($requestUri)) {
		list($method, $requestUri) = $requestUri;
	}
	return rt_api::request($requestUri, $data, $method, $r = 'metro');
}

class metro_api extends _api {
	static $r = 'metro';

	static $dbg = false;
	static $dbgApi = true;
	static $dbgMe = true;
	static $dbgGet = true;
}
