<?#0.0.2 - db manager

//q4
class dbs {
	static $struct = array();

	static function init($asset = false){
		static::asset($asset);
	}

	static function asset($struct = true){
		if ($struct === true) $struct = pro::db_struct();
		static::$struct = $struct;
	}
}
