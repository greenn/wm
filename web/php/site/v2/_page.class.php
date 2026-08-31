<?

//вспомогательный класс с функциями по работе с данными
class _page {

	static function strPattern($pattern, $dataCtx = array()){

		if ($dataCtx === true) $dataCtx = data();

		preg_match_all('/%([a-z-]+)/', $pattern, $matches);
		$search = array();
		$replace = array();

		//dx($pattern, $dataCtx, $matches[1]);
		foreach ($matches[1] as $placeholder) {
			$value = getValueByPath($dataCtx, $placeholder);
			//d($placeholder, $value);
			if ($value !== null) {
				$search[] = "%$placeholder";
				$replace[] = $value;
			}
		}

		// Производим замену в шаблоне
		$result = str_replace($search, $replace, $pattern);
		//dx($result, $search, $replace, $pattern);
		return $result;
	}

	static function pageTitlePattern($dataCtx = true){
		static $pattern = array();
		if (!$pattern) {
			if ($dataCtx === true) $dataCtx = data();

			$pattern['glue'] = _prop($dataCtx, array('page-title', 'glue'), ' • ');
			$pattern['suffix'] = _prop($dataCtx, 'base-title', site('hostName')); //hostName
			if ($baseTitlePattern = _prop($dataCtx, 'base-title-pattern')) {
				$pattern['suffix'] = _page::strPattern($baseTitlePattern, $dataCtx);
			}
		}
		return $pattern;
	}
	//формирование заголовка для вкладке в браузере
	static function pageTitle($text){
		$pattern = static::pageTitlePattern();
		//dx($text, $pattern);

		$titleSuffix = $pattern['suffix'];
		$titleGlue = $pattern['glue'];

		if (!$text) {
			//case eg: titul-page
			$title = $titleSuffix;
		} else {
			//case base
			$title = join_values($titleGlue, array(
				$text,
				$titleSuffix
			));
		}
		return $title;
	}
}


