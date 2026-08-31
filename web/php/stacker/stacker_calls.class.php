<?

//0|L|d
class stacker_calls extends stacker { //v2 legacy

	/*
	    в ::req()
		if (is_array($arg1)) { //0 - [mb] через опцию
			return static::reqArg($args);
		}

		::post_req()
			//listing ~ 0
			if (!isset(static::$listing[$rName])) static::$listing[$rName] = array();
			if (!isset(static::$listing[$rName][$tplName])) static::$listing[$rName][$tplName] = array();
			if (!isset(static::$listing[$rName][$tplName][$hash])) static::$listing[$rName][$tplName][$hash] = 0;
			static::$listing[$rName][$tplName][$hash]++;

	*/

	//static $listing = array();


	static function selfCall($method, $args) {
		return call_user_func_array("static::$method", $args);
	}

	//вызов своего статического метода с параметрами: ::($ctx, $arg1 = null, $argN = null)
	//[ph] нету смысла в этом \
	static function callArgs($method, $args, $selfMethod = true){
		if ($selfMethod) $method = "static::$method";
		array_unshift($args, $args);
		return call_user_func_array($method, $args);
	}
	//static function callArgsAppend($method, $args, $append, $selfMethod = true){}

	//возможность указания внешнего роутера для вызовов
	static $callRouter = array();
	static function customCall($method, $args){
		$hasRes = false;
		$res = null;
		$custom_method = null;


		$router = static::$callRouter;
		if (is_string($router)) {
			if (is_callable($router)) { //static $callRouter = 'rp_stacker::call';
				$custom_method = $router;
			} elseif (strpos($router, '::') !== false) { //static $callRouter = 'rp_stacker::$callRouter';
				list($className, $property) = explode('::', $router);
				$property = ltrim($property, '$');
				if (class_exists($className) && property_exists($className, $property)) {
					$vars = get_class_vars($className);
					$router = prop($vars, $property);
				}
			}
		}

		if (is_array($router)) {
			$custom_method = prop($router, $method);
		}

		if ($custom_method) { //is_callable($custom_method)
			$hasRes = true;
			$res = call_user_func_array($custom_method, $args);
			//$res = static::callArgs($custom_method, $args, false);
		}

		return array($hasRes, $res);
	}

	//получение результата по имени метода и заявленным данным
	static function call($method/*, #arg1, $argN*/){
		$args = func_get_args();
		$method = array_splice($args, -1);
		$conf = $args;

		/*if ($custom_method = prop(static::$callRouter, $method)) {
			return call_user_func_array($custom_method, $args);
		}*/

		$customCall = static::customCall($method, $args);
		if ($customCall[0]) return $customCall[1];

		$method = "static::$method";

		return is_callable($method)? call_user_func_array($method, $conf) : false;
		//return static::callArgs($method, $args);
	}

}