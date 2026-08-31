<?#0.4.1
//base resources
_needphp(
	'site/v2/r/rt.class'
);

class rb extends rt {
	static $rClass = 'rb';
	static $temp; //01

#= extend-update
	static function nc($name = true, $subName = false, $usePrefix = true){
		$n = parent::nc($name, $subName, false);
		return $usePrefix ? 'b'.$n : $n;
	}
#\
}

//менеджер по работе с rp классом
class _rb extends _rt {
	static $rClass = 'rb';
	static $db = array(); //своя база
	static $cache = array(); //свой cache

	static function rDir(){
		return ROOT.'/r/rb';
	}

	static function className($name){
		return "rb_$name";
	}

}

function rb($name, $method = null/*, $arg1, $arg2*/){
	return _r_('rb', func_get_args());
}

function rb_tpl($name, $tplName, $tplCtx = false, $fileExt = 'tpl.php'){
	return _r_tpl('rb', func_get_args());
}
