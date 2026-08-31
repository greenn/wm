<?#3.6.1 - acc|lk

need_pro('rt.class');


class _cssAcc extends _css {
	static $db = array(); //своя база
	static $mq = array(); //своя база хранения mq-параметров
}

function _cssAcc($name){
	$arg = func_num_args() > 1 ? func_get_args() : $name;
	return _cssAcc::val($arg);
}

class acc_i extends _img {
	static $dir = 'i/acc';
}


class acc extends rt {
	static $rClass = 'acc';
	//01
		static $temp;
		static $vtpl = false;
		static $vdef = 0;
		static $vname = array();

	static function nc($name = true, $subName = false, $usePrefix = true){
		$n = parent::nc($name, $subName, false);
		return $usePrefix ? 'acc'.$n : $n;
	}
}

//менеджер по работе с acc классом
class _acc extends _rt {
	static $rClass = 'acc';
	static $db = array(); //своя база
	static $cache = array(); //свой cache

	static function rDir(){
		return ROOT.'/r/acc';
	}

	static function className($name){
		return "acc_$name";
	}
}

function acc($name, $method = null/*, $arg1, $arg2*/){
	return _r_('acc', func_get_args());
}

function acc_tpl($name, $tplName = true, $tplCtx = false, $fileExt = 'tpl.php'){
	$args = func_get_args();
	array_unshift($args, 'acc');
	return tpl_($args);
	//return _r_tpl('acc', func_get_args());
}

function acc_tpl_($Args) {
	return call_user_func_array('acc_tpl', (array)$Args);
}

function acc_vtpl($name, $tplName = true, $tplCtx = false, $fileExt = 'tpl.php'){
	return acc_tpl($name, $tplName, $tplCtx, $fileExt, 'vtpl');
}

_rt::req('api');

/*
	ug
		api_acc('side-menu/list', array('by' => 'link'))
	    api_acc('targets/list')
	    acc_api::get_prop('list', 'targets/list')
*/
function api_acc(/*$method,*/ $requestUri, $data = array()){
	$method = 'get';
	if (func_num_args() === 3) {
		list($method, $requestUri, $data) = func_get_args();
	}
	if (is_array($requestUri)) {
		list($method, $requestUri) = $requestUri;
	}
	return rt_api::request($requestUri, $data, $method, $r = 'acc');
}

class acc_api extends _api {
	static $r = 'acc';

	//свои настройки
	static $dbg = false;
	static $dbgApi = true;
	static $dbgMe = true;
	static $dbgGet = true;
}

