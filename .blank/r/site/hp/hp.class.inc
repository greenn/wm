<?

_site::reg('hp', array());

class site_hp extends site {

	static $nsCityState = 'page-city-state';
	static function curCityCid(){
		return _s(false, static::$nsCityState, _pro('contacts', 'city-def'));
	}
	static function cityTitle($index = true){
		if ($index === true) $index = site('page', 'curCityCid');
		return _pro('contacts', 'city-list', $index, 0);
	}

}
