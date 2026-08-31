<?#3.7.0-lay - custom r-resource = lay

need_pro('rt.class');


class lay extends rt {
	static $rClass = 'lay';
	//01
		static $temp;
		static $vtpl = false;
		static $vdef = 0;
		static $vname = array();

	static function nc($name = true, $subName = false, $usePrefix = true){
		$n = parent::nc($name, $subName, false);
		return $usePrefix ? 'lay'.$n : $n; //ly
	}

	static function tpl($tplName, $tplCtx = false, $ext = 'tpl.php'){
		$autoTplName = "$tplName/$tplName";
		//dx($autoTplName, static::hasTpl($autoTplName, $ext));
		if (static::hasTpl($autoTplName, $ext)) {
			$tplName = $autoTplName;
		}
		return parent::tpl($tplName, $tplCtx, $ext);
	}

}

//менеджер по работе с lay классом
class _lay extends _rt {
	static $rClass = 'lay';
	static $db; //своя база
	static $cache; //свой cache

	static function rDir(){
		return ROOT.'/r/lay';
	}

	static function className($name){
		return "lay_$name";
	}
}

function lay($name, $method = null/*, $arg1, $arg2*/){
	return _r_('lay', func_get_args());
}

function lay_tpl($name, $tplName = true, $tplCtx = false, $fileExt = 'tpl.php'){
	return _r_tpl('lay', func_get_args());
}