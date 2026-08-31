<?#3.5.2

class need {
	private static $order = array();
	private static $list = array();

	static function get_info(){
		_needphp('str/startsWith');

		$needs = array();
		foreach (static::$order as $path) {
			$count_def = '?';
			$prefix = '';

			if ($path[0] === ' ') {
				//d($path);
				$path = ltrim($path);
			}
			if ($path[0] === '!') {
				$path = ltrim($path, '!');
				$count_def = '!';
			}

			$lessPath = PHP;
			if (startsWith($path, LIB)) {
				$prefix = 'lib';
				$lessPath = LIB;
			}
			if (startsWith($path, INC)) {
				$prefix = 'inc';
				$lessPath = INC;
			}
			$iqDir_def = ROOT.'/iq/php';
			if (startsWith($path, $iqDir_def)) {
				$prefix = 'iq';
				$lessPath = $iqDir_def;
			}

			$name = strLess(strLess($path, "$lessPath/"), '.php', true);
			$count = isset(static::$list[$path]) ? static::$list[$path] : $count_def;

			if ($prefix) $name = ":$prefix $name";
			$needs[$name] = $count;
		}

		$needs_abc = $needs;
		ksort($needs_abc);
		$needs_list = array_keys($needs);
		return array(
			'needs_list' => $needs_list,
			'needs_abc' => $needs_abc,
			'needs' => $needs,
			'list' => static::$list,
			'order' => static::$order,
		);
	}

	static $php = PHP;

	//(для-пурядку) активируем вручную заинклюженные файлы
	// а так обычно (например в need::php) это происходит автоматом
	static function init(){
		foreach (func_get_args() as $arg) {
			static::php($arg);
		}
	}

	private static function _php($path){
		//echo is_file($path) ? '+': 'x', ' ', $path, '<br />';
		if (is_string($path)) {
			if (is_file($path)) {
				if (!isset(static::$list[$path])) {
					static::$list[$path] = 0;
				}
				include_once($path);
				static::$list[$path]++;

				$path = str_repeat(' ', static::$list[$path] - 1).$path;
				//пробелы покажут какой по счёту раз ставлен
				//так же можно будет лего отфильтровать последующий вставки
				//(они начинаются с пробелов)
			} else {
				$path = '!'.$path;
			}

			static::$order []= $path;
		}
	}

	static function php($phpName){
		$path = static::$php.'/'.$phpName.'.php';
		static::_php($path);
	}

	static $pro = 'iq/php'; //def
	static function pro($phpName){
		$path = static::$pro.'/'.$phpName.'.php';
		static::_php($path);
	}

	static function path($phpName, $dirPath = false){ //custom
		$path = ($dirPath ? $dirPath.'/' : '').$phpName.'.php';
		//dx('need::path', $phpName, $dirPath, $path, is_file($path));
		static::_php($path);
	}

	static $lib = LIB; //def
	static function lib($libName){
		$path = static::$lib.'/'.$libName.'/'.$libName.'.php';
		static::_php($path);
	}

	//Ls
	static $inc = INC; //def
	static function inc($incName){
		$path = static::$inc.'/'.$incName.'.inc';
		if (substr($incName, -4 ) === '.php') {
			$path = static::$inc.'/'.$incName;
		}
		//d($incName, $path, is_file($path));
		static::_php($path);
	}
}



