<?

_kot::reg('app', array(
	'nc' => array(
		'base' => 'A'
	),
));

class kot_app extends kot {


	static $nsSideState = 'app-side-state';
	static function sideState(){}

	static $host = '';
	static function fake($pngName){
		return rb('wd', 'fake_src', "/kot/img/fake/$pngName.png", static::$host);
	}

	static function date_value_format($date, $format = 'front'){
		static $mapFormat = array(
			'db' => 'Y-m-d H:i:s',
			'js-time' => 'Y-m-d\TH:i',
			'js-date' => 'Y-m-d',
			'front' => 'd.m.Y H:i:s',
			'copy' => 'd/m/Y H:i:s',
		);

		if (is_numeric($date)) { //ak tmp
			$dateTime = new DateTime();
			$dateTime->setTimestamp($date);
		} else {
			$dateTime = new DateTime($date);
		}
		$format = prop($mapFormat, $format, $format);
		return $dateTime->format($format);
	}
}

