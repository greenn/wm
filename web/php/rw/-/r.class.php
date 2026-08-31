<?#0.1

class rw_x {

	static $rpName; //не хранит реальное значение, используется только для возможного указания определлёного rpName
	static function rpName(){
		$self = get_called_class(); //$self = static::class;
		$rpName = property_exists($self, 'rpName') ? $self::$rpName : null;
		if (!$rpName) $rpName = preg_replace('~^rp_~', '', $self);

		if ($rpType = static::x('rpType')) { //составное rpName
			$rpName = "$rpType:$rpName"; //¦:¦/¦
		}
		//dx($rpName, static::x('rpType'), $rpType);

		return $rpName;
	}

}