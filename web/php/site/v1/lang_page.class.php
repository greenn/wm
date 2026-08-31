<?#1.0.0 - lang functionality для page{}

class lang_page extends page {
	///const usePrefix = true; //использовать ли языковую прейикс метку для несуществующих переводов
	/// перешло уже в _lang::$otherwiseUsePrefix

	//получает если есть языковое значение для prop
	function lang($prop/*{s,oa}*/, $lang = true) {
		$data = $this->prop($prop);
		//dx($data);
		return _lang($data, $lang);
	}

	//menu-title, page-title, content-title
	function lang_title($type, $lang = true){
		return _lang(parent::title($type), $lang);
	}

	function lang_link($lang = true){
		$link = parent::link();
		if ($link !== false) {
			if ($lang) {
				$link = ltrim($link, '/');
				if ($lang === true) $lang = cur_lang();
				$link = "/$lang/$link";
			}
		}
		return $link;
	}
}
