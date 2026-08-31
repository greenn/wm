<?#3.6.0 - custom resource = draft

need_pro('rt.class');


class draft extends rt {
	static $rClass = 'draft';
	static $temp; //01

	static function nc($name = true, $subName = false, $usePrefix = true){
		$n = parent::nc($name, $subName, false);
		return $usePrefix ? 'dft'.$n : $n;
	}
}

//менеджер по работе с draft классом
class _draft extends _rt {
	static $rClass = 'draft';
	static $db = array(); //своя база
	static $cache = array(); //свой cache

	static function rDir(){
		return ROOT.'/r/draft';
	}

	static function className($name){
		return "draft_$name";
	}
}

function draft($name, $method = null/*, $arg1, $arg2*/){
	return _r_('draft', func_get_args());
}

function draft_tpl($name, $tplName = true, $tplCtx = false, $fileExt = 'tpl.php'){
	$args = func_get_args();
	array_unshift($args, 'draft');
	return tpl_($args);
	//return _r_tpl('draft', func_get_args());
}