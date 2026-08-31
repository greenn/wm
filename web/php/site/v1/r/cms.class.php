<?#3.6.1 - cms

need_pro('rt.class');


class cms extends rt {
	static $rClass = 'cms';
	static $temp; //01

	static function nc($name = true, $subName = false, $usePrefix = true){
		$n = parent::nc($name, $subName, false);
		return $usePrefix ? 'cms'.$n : $n;
	}
}

//менеджер по работе с cms классом
class _cms extends _rt {
	static $rClass = 'cms';
	static $db = array(); //своя база
	static $cache = array(); //свой cache

	static function rDir(){
		return ROOT.'/r/cms';
	}

	static function className($name){
		return "cms_$name";
	}
}

function cms($name, $method = null/*, $arg1, $arg2*/){
	return _r_('cms', func_get_args());
}

function cms_tpl($name, $tplName = true, $tplCtx = false, $fileExt = 'tpl.php'){
	$args = func_get_args();
	array_unshift($args, 'cms');
	return tpl_($args);
	//return _r_tpl('cms', func_get_args());
}