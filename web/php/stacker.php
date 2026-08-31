<?#5.1.0 - 'Накопитель'
/*
    единый глобальный объект сбора указаний

	для создание другого объекта используй
	class new_stacker extends stacker { static $stack = array(); }
*/

_needphp(
	//'x'
);

class stacker {

	//функциональный переменные, обязательны к повтороному объявлению при наследовании
	static $hash = array(); //расшифровка хашей / хранилище значений
	static $order = array(); //кофигурация порядка
	static $_stack = null; /* результатный список значений [генерируемое, квази-приватное]
		q по-сути нигде оно и не используется
            оно идёт как промежуточное (временное) хранение
            данные беруться из each_with > get_stack
                на прямую с static::$_stack никто и не работает,
    */
	static $_ruledStack = null; //|ruledStack|orderedStack|mapStack

	/*#! [extension]
		static $hash = array();
		static $order = array();
		static $_stack = null;
	*/
	//\функциональный переменные


	//составление данных для добавления в стек
	//1 вычиление req-данных (конфига) для $hash массива
	static function build_conf(/*args*/){
		$ctx = func_get_args();
		return $ctx;
	}

	static function hash($data){
		return hash('adler32', is_stringable($data) ? $data : serialize($data));
	}



	static $nameData = array();

	static function req(/*args*/){
		$args = func_get_args();
		return static::push($args);
	}

	//req_index|req_index|req_rule|
	static function req_index($rule/*, args*/){
		$args = array_slice(func_get_args(), 1);
		return static::push($args, $rule);
	}

	static function req_conf($conf){
		if (is_array($conf)) {
			$methodName = is_integer($conf[0]) ? 'req_index' : 'req';
			call_user_func_array("static::$methodName", $conf);
		}

	}
    static function req_name($reqName){
        $reqConf = prop(static::$nameData, $reqName);
        static::req_conf($reqConf);
    }

	static function reqArg($args){
		return call_user_func_array('static::req', $args);
	}


	static function push($data, $key = 0){ //key ak ruleIndex
		$conf = call_user_func_array('static::build_conf', $data);
		$hash = static::hash($conf);

		//обнуляем, т.к. поступили новые данные, значит результат надо перестроить
		static::$_stack = null;
		static::$_ruledStack = null;

		$conf['$order'] = $key; //например так [01]

		static::$hash[$hash] = $conf; //$serConf


		if (!isset(static::$order[$key])) static::$order[$key] = array();
		static::$order[$key] []= $hash;

		//::save_data($hash, $serConf);

		return $hash;
	}



	static function reset_stack(){
		static::$hash = array();
		static::$order = array();
		static::$_stack = null;
		static::$_ruledStack = null;
	}


	//формирование результативного стека [hash: значение], согласно order
	static function get_stack(){
		if (is_null(static::$_stack)) {
				/*  static::$_stack - обнуляется
						при новом push-в-$hash
						при reset_stack
				*/
			ksort(static::$order);

			$list = array();
			foreach (static::$order as $rule => $stack) {
				$list = array_merge($list, $stack);
			}

			static::$_stack = array();
			//d($list, static::$order);
			foreach (array_unique($list) as $hash) {
				static::$_stack[$hash] = static::$hash[$hash];
			}
		}

		return static::$_stack;
	}

	static function get_ruled_stack(){
		if (is_null(static::$_ruledStack)) {
			ksort(static::$order);
			dx(static::$order);
		}
		return static::$_ruledStack;
	}


	//выполнение перебора уникальных элементов стека с указанным колбеком
	static function each_with($callback, $res = array(), $extra = null){
		//dx($callback, is_callable($callback));
		if (!is_callable($callback)) return $res;

		$stack = static::get_stack();
		//d('each_with:get_stack' . '@'.get_called_class(), $stack, static::$hash);

		foreach ($stack as $hash => $conf) {
			$res = static::each_callback($callback, $res, $conf, $hash, $extra);
			//d($conf, $res);
		}
		return $res;
	}

	//вызов колбека
	static function each_callback($callback, &$res, $conf, $hash, $extra = null){
		$args = static::each_callback_args($res, $conf, $hash, $extra, $callback);
		if (is_array($args)) {
			$callRes = call_user_func_array($callback, $args);
			if ($callRes) $res = $callRes;
		}
		return $res;
	}

	#[extend]
	//пред-обработка данных / формирование аргументов для вызова
	/* [eg]

		static function each_callback_args(&$res, $conf, $hash){
			$args = false;
			$item = static::call('build_item', $conf);
			if ($item) {
				//$args = array_merge(array(&$res, $hash, $item), $conf);
				$args = array(&$res, $item, $conf, $hash);
			}
			return $args;
		}
		//
		static function build_item(){ //|build_obj|build_item|
			//static $cache = array();
			return false;
		}
	*/
	static function each_callback_args(&$res, $ctx, $hash, $extra, $callback){
		return array(&$res, $ctx, $hash, $extra);
	}
}