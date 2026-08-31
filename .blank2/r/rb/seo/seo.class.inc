<?

_rb::reg('seo', array(
	'nc' => array(
		'base' => 'seo'
	),
));

class rb_seo extends rb {

	static function ya_metrika($code = true, $localhostAccess = false){
		$html = '';
		
		if (!$localhostAccess && isLocalhost) return $html; //если не включено использование на локалхост и это локалхост, то выключаем использование
		
		if ($code === true) {
			$code = pro('seo-ya', 'code');
		}


		if ($code) {
			$html = static::tpl('ya-metrika', array('code' => $code));
		}

		//dx($code, $html);
		return $html; 
	}
}
