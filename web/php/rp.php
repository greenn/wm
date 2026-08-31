<?#1.1

//RB DL
_needphp('useTemplate');


class rps { //static-handler for rp

	private static $locateStringArgOrder = array('incPath', 'relBase');
	static function locate(){
		$obj = obj();

		return self::produce_obj($obj);
	}

	private static function produce_obj($obj){
		$r = obj();
		return $r;
	}

	static function tpl($r, $ctx = null, $replace = null, $replaceRegex = null){

		return useTemplate($r->tpl, $ctx, $replace, $replaceRegex);
		//tpl
	}
}