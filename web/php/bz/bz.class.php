<?#0.2.1553d
/*
	агрегатор доступ к базе данных
	поддерживает варианты доступа к базе
	jbz - json-file bz
	fbz - file bz
	mbz - mysql bz
*/

_needphp(
	'bz/jbz.class',
	'bz/fbz.class',
	'bz/mbz.class'
);

class bz {
	static $proxyRes;
	static $proxy = array();
	static function proxy($method, $args_){
		$results = array();
		foreach (static::$proxy as $type => $proxy) {
			$results[$type] = call_user_func_array(array($proxy, $method), $args_);
		}
		return static::proxyRes($results);
	}
	static function proxyRes($results){
		$res = reset($results);
		if (static::$proxyRes) {
			$res = $results[static::$proxyRes];
		}
		return $res;
	}

	static function addProxy($type, $config){
		$bzClass = $type;
		$bz = new $bzClass;
		$bz::init($config);
		static::$proxy[$type] = $bz;
	}
	
	static function init($proxyConfig = 'jbz', $resType = false){
		if (is_string($proxyConfig)) {
			$type = $proxyConfig;
			$proxyConfig = array();
			$proxyConfig[$type] = false;
		}
		foreach ($proxyConfig as $type => $config) {
			static::addProxy($type, $config);	
		}
		if ($resType) {
			static::$proxyRes = $resType;
		}
	}



	public static function __callStatic($method, $args_) {
		//**: значение $method регистрозависимо.
		return static::proxy($method, $args_);
	}

	/*
		static function create(){
			return static::proxy('create', func_get_args());
		}
	*/
}