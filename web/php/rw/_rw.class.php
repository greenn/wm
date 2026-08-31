<?#0.3.333

_needphp(
	'strLess' //pathLess
);


//_needphp('url.class');

//класс по работе с rw
class _rw {
	static $rClass = 'rw'; //02

	//значение директории по умолчанию
	static function rDir(){
		return ROOT;
	}
	//имя класса по умолчанию
	static function className($name){
		return "r_$name";
	}

	static function rPath($name, $subPath = false){
		$path = static::rDir()."/$name";
		if ($subPath) $path .= "/$subPath";
		///*dbg*/if ($name === 'css/materialize') d('rPath', $path, $subPath);
		return $path;
	}
	static function rClass($name, $cfg = false){
		//$file = "$name.class.inc";                //ok
		$file = basename($name).".class.inc";       //upd для авто rt-rel-типа - _rt::reg('css/materialize')
		if ($cfg && isset($cfg['classFile'])) {
			$file = $cfg['classFile'];
		};
		///*dbg*/if ($name === 'css/materialize') d('rClass', $file, $cfg);
		return static::rPath($name, $file);
	}
	/*
		static function init(&$cfg, $name){ //ak cfg_update
			if (!array_key_exists('className', $cfg)) {
				$cfg['className'] = static::className($name, $cfg);
			}
			if (!array_key_exists('rDir', $cfg)) {
				$cfg['rDir'] = static::rPath($name, $cfg);
			}
			if (!array_key_exists('rPath', $cfg)) { //className|cName|clName|rFile|rPath
				$cfg['rClass'] = static::rClass($name, $cfg);
			}
		}
	*/

//= конфиг / контекст-конфига
	static $db = array();
	//зарегать
	static function reg($name, $cfg) { #|reg|init|
		//static::init($cfg, $name);

		//d($name, $cfg, static::$rClass);

		$cfg['rName'] = $name;
		$has_className = array_key_exists('className', $cfg);
		$has_rClass = array_key_exists('rClass', $cfg);
		$has_rDir = array_key_exists('rDir', $cfg);

		if (!$has_className) {
			$cfg['className'] = static::className($name);
		}
		if ($has_rClass && !$has_rDir) {
			$cfg['rDir'] = dirname($cfg['rClass']);
		}
		if (!$has_rDir) {
			$cfg['rDir'] = static::rPath($name);
		}
		if (!$has_rClass) { //className|cName|clName|rFile|rPath
			$cfg['rClass'] = static::rClass($name, $cfg);
		}

		//step: добавляем кониг в базу
		static::$db[$name] = $cfg;

		//if (static::$rClass === 'gss3') d($name, $cfg, static::$db);

		//step: получаем данный ресурс
		$r = static::name($name);
		//if (static::$rClass === 'gss3') dx($name, $r, $cfg, get_called_class());
		//step: устанавливаем в него конфиг - ak запускаем
		if(!1) if ($name === 'posts') {
			dx($name, $cfg, $r, $cfg['className'], trait_exists('site_getModItemData'), class_exists($cfg['className']));
		}

		$r::_cfg($cfg);
		return $r;
	}
	//получить$
	static function cfg($name){ //get_cfg|cfg|
		$cfg = null;
		//d($name, _rw::$db, static::$db, get_called_class(), debug_backtrace());
		//d($name, static::$db);
		if (array_key_exists($name, static::$db)) {
			$cfg = static::$db[$name];
		}
		return $cfg;
	}

//= инстанс
	static $cache = array();

	//подключаем ресурс - инклюдим класс
	static function req($name) { //|need|req|
		if (isset(static::$cache[$name])) return true;

		//запрос по имени, в $db не ищем, т.к. по идеи его там нет
		//хотя может и пробывать, может reg-запросы могут быть в другом месте
		//хотя нет, при ргеистрации создаётся инстанс, поэтому он будеи в $cache
		//$cfg = static::cfg($name);

		$path = static::rClass($name);
		///*dbg*/if ($name === 'css/materialize')
		//d('req', $name, is_file($path), $path);

		if (is_file($path)) {
			include_once $path;
			return true;
		}

		return false;
	}

	//запрашиваем на получение список r-имён
	static function need($name/*, $another_name*/) {
		$list = func_get_args();
		foreach ($list as $name) {
			$result []= static::req($name);
		}
	}

	//получить инстанс ресурса по имени
	static function name($name) { //|get|name
		if (isset(static::$cache[$name])) {
			return static::$cache[$name];
		}

		//d('req', static::$rClass, $name);
		static::req($name);
		///*dbg*/if ($name === 'css/materialize') d('name', $name, static::cfg($name));

		//if ($name === 'page') dx('req-res', $name, static::cfg($name), static::$db);

		if ($cfg = static::cfg($name)) {


			$rClass = $cfg['className'];
			//if ($name === 'page') dx($rClass, $cfg, class_exists($rClass));

			if (class_exists($rClass)) {

				try {
					$R = new $rClass;
					// Другой код, который может вызвать исключения или ошибки
				} catch (Throwable $e) { // Throwable перехватывает и исключения, и ошибки
					echo "Произошла ошибка при создании объекта: ", $e->getMessage(), "\n";
					echo "Файл: ", $e->getFile(), "\n";
					echo "Строка: ", $e->getLine(), "\n";
				}

				static::$cache[$name] = $R;


				return $R;
			}
		}

		return false;
	}

//-
	static function self($callIndex = 0){
		if (is_string($callIndex)) {
			//case: $callIndex is path \eg ::self(__FILE__)
			$callFile = $callIndex;
			$name = static::path_rName($callFile);
		} else {
			//else normal case
			$name = static::self_rName($callIndex + 1);

		}

		//dx($name, static::name($name));
		return static::name($name);
	}
	static function self_rName($callIndex = 0){
		$callStack = debug_backtrace();
		$caller = $callStack[$callIndex];
		$callFile = $caller['file'];
		//dx($callIndex, $caller, $callStack, '=', $callFile);
		return static::path_rName($callFile);
	}

	static function path_rName($path){
		$relPath = pathLess($path, static::rDir());
		$pathNames = explode(DS, ltrim($relPath, DS), 2);
		//dx($path, $relPath, $pathNames);
		return $pathNames[0]; //$name
	}

#html helpers

	static $js_link = "<script type=\"text/javascript\" src=\"%s\"></script>\r\n";
	static $css_link = "<link type=\"text/css\" rel=\"stylesheet\" href=\"%s\" />\r\n";
	static function html_link($type, $url){
		//d($type, $url);
		$pattern = static::${"$type".'_link'}; //dx($pattern);
		return sprintf($pattern, $url);
	}

// helpers
	static function getStatic($rName, $propName) {
		$R = static::name($rName);
		if ($R && isset($R::$$propName)) {
			return $R::$$propName;
		}
	}

// операции с ресурсами
	//call
}


function rw($name, $method = null/*, $arg1, $arg2*/){
	return _r_('rw', func_get_args());
}

function rw_tpl($name, $tplName, $tplCtx = false, $fileExt = 'tpl.php'){
	return _r_tpl('rw', func_get_args());
}