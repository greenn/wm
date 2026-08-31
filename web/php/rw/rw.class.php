<?#0.5.3

_needphp(
	//'x/x-slice',
	'fq/_props',
	'dataPath',
	'fileUrl',
	'strLess' //relPath
);

//_needphp('url.class');

class rw {
	static $rClass = 'rw';

//= конфиг ресурса
	//получение/устанока
	static function _cfg(/*$setCfg*/){
		static $cfg;
		switch (func_num_args()) {
			case 0: return $cfg; //case getCfg
			case 1: $cfg = func_get_arg(0); break; //case: $setCfg
		}
	}
	//получение данных из конфига
	static function cfg($prop = null, $otherwise = null){
		$cfg = static::_cfg();
		if (is_array($prop)) {
			return dataPath($prop, $cfg, $otherwise);
		} else {
			return prop($cfg, $prop, $otherwise);
		}
	}
	static function cfg_(/*$prop1, $propN*/){
		return static::cfg(func_get_args());
	}

//= path/uri
	//$subPath может быть задан как array($subPath, $ext)
	static function path($subPath = '', $ext = ''){
		$path = static::cfg('rDir');

		if ($subPath) {

			if (is_array($subPath) && ($subPath[0] === false)) {
				//spec case: row path array(false, $realpath)
				$path = $subPath[1];
			} else {
				if (is_array($subPath)) {
					//spec case uu: передача расширения, вторым ao-параметром, а не аргументом
					//когда в переменной путь, хранится расширение
					//когда суб-путь передан в первом ao-параметре
					$ext = isset($subPath[1]) ? $subPath[1] : '';
					$subPath = $subPath[0];
				}
				//if (!$path) dx($path, $subPath, static::_cfg(), new self);

				$path .= $subPath === '/' ? $subPath : "/$subPath";
				if ($ext) {
					$path .= ".$ext";
				}
			}


		}
		return $path;
	}


	static function relName($ext = true, $selfPath = true){
		if ($selfPath === true) $selfPath = 0;
		if (is_integer($selfPath)) {
			$callIndex = $selfPath;
			$callStack = debug_backtrace();
			//d($callStack);
			$caller = $callStack[$callIndex];
			$selfPath = $caller['file'];
		}
		$relPath = pathLess($selfPath, static::path('/'));
		if ($ext === true) $ext = pathinfo($selfPath, PATHINFO_EXTENSION);
		if ($ext) {
			$relPath = pathinfo($relPath, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . basename($relPath, ".$ext");
		}
		return $relPath;
	}

	//$selfPath - относительно чего считать relDir
	//::relDir(true, __FILE__);
	/*pr
		при вызове из /api/, выдаёт uri а не path
		 $response['data2path'] = $Self::relDir('data/listing.data', __FILE__);
	*/
	static function relDir($subPath = '', $selfPath = true){
		if ($selfPath === true) $selfPath = 0;
		if (is_integer($selfPath)) {
			$callIndex = $selfPath;
			$callStack = debug_backtrace();
			$caller = $callStack[$callIndex];
			$selfPath = $caller['file'];
		}
		//dx(1);
		$relPath = pathLess(dirname($selfPath), static::path('/'));
		if (is_string($subPath) && $subPath) {
			if ($subPath === '/') $subPath = ''; //case: $Self::relDir('/') - с закрывающим слешем
			$relPath .= '/'.$subPath;
		}
		return $relPath;
	}

		//не корректно работает с source::dep_req
		static function relDir_($subPath = '', $selfPath = true){
			if ($selfPath === true) $selfPath = 1;
			elseif (is_integer($selfPath)) $selfPath += 1;
			$relPath = dirname(static::relName(false, $selfPath));
			if (is_string($subPath) && $subPath) $relPath .= '/'.$subPath;
			return $relPath;
		}


	static function uri($subPath = ''){
		$path = static::path($subPath);
		$uri = fileUrl($path, true, ROOT);
		//dx($uri, $path, $subPath);
		return $uri;
	}

//= temp ak tmpCtx|tplCtx
	static $temp = array();
	static function temp_push($data){
		static::clear_store_last(); //для: tpl, inc
		static::$temp []= $data;
		//d('temp_push', static::$rClass, static::$temp);
	}
	static function temp_pop(){
		return array_pop(static::$temp);
	}
	static function temp_last(){
		//d('temp_last', static::$rClass, static::$temp);
		//if (!static::$temp) return array();
		return end(static::$temp);
	}

	static function tempCtx($defValues = array()){
		$setValues = static::temp_last();
		//dx($defValues, $ctxValues);
		//_array_unset_undefined($ctxValues);
		$ctx = $setValues ? array_replace($defValues, $setValues) : $defValues;
		return $ctx;
	}

	static $store = array();
	static $store_last_name = '';
	static $store_last_index = 0;
	static function clear_store_last(){ //|clear_store_last|store_last_clear
		static::$store_last_name = '';
		static::$store_last_index = 0;
	}
	static function store_last(/*$prop*/){
		$_args = func_get_args();
		array_unshift($_args, static::$store_last_name, static::$store_last_index);
		return call_user_func_array('static::store_get', $_args);
	}
	static function store_get($name, $index = true, $prop = null){
		if ($index === true) $index = static::store_get_index($name); //ak last
		$_args = func_get_args();
		$_args[1] = $index;
		array_unshift($_args, static::$store);
		return call_user_func_array('propChain', $_args);
	}
	static function store_get_index($name, $next = false){
		if (!isset(static::$store[$name])) static::$store[$name] = array();
		$index = count(static::$store[$name]);
		return $next ? $index : /*last*/ $index - 1;
	}

	//сохранить в магазин {relName} - $prop | $prop = $value
	static function store($prop, $value = null, $ext = true){
		$name = static::relName($ext, 1);
		static::store_in($name, $prop, $value);
	}

	//сохранить в магазин {tplName} - $prop | $prop = $value
	static function tpl_store($prop, $value = null, $ext = 'tpl.php'){
		$name = static::relName($ext, 1);
		static::store_in($name, $prop, $value);
	}

	//сохранить в магазин $name - $prop | $prop = $value
	static function store_in($name, $prop, $value = null){
		$data = array();
		if (is_array($prop)) $data = $prop;
		else $data[$prop] = $value;
		$index = static::store_get_index(true);
		static::$store[$name][$index] = $data;
		static::$store_last_name = $name;
		static::$store_last_index = $index;

		//id store_notify(rClass, $name, $index)
	}

//= tpl
	static function tpl_path($tplName, $ext = 'tpl.php'){
		if (is_array($tplName)) {
			//case spec: для передачи (например) внешнего (не-родного) пути темплейта
			$tplPath = join('', $tplName);
		} else {
			//case base
			$tplPath = static::path($tplName, $ext);
		}
		return is_file($tplPath) ? $tplPath : false;
	}

	static function tpl($tplName, $tplCtx = false, $ext = 'tpl.php'){
		$tplPath = static::tpl_path($tplName, $ext);
		if (!$tplPath) return '';

		//gIncr('preventHeaders');
		static::temp_push($tplCtx);

		ob_start();
		include $tplPath;
		$result = ob_get_clean();

		static::temp_pop();
		//gDecr('preventHeaders');

		return $result;
	}

	static function hasTpl($name, $ext = 'tpl.php'){
		return is_file(static::path($name, $ext));
	}


	static $vtpl = false; //настройки версий темплейтов
	static $vdef = 0; //версия по умолчанию
	static $vname = array(); //настройки путей версионных темплейтов

	static function vtpl($name, $tplCtx = false, $ext = 'tpl.php', $forceUsage = false){
		//d(static::$vtpl, $name, $tplCtx);

		if (!static::$vtpl) { //case: static $vtpl = false || $vtpl = array() - пропустить исользование версионных темплейтов

			$vname = $name; //def case: miss vtpl functionality

			if (is_array($name)) {//case: версия передаётся, но конфига нету
				//case: не используем версию
				list($name, $v) = $name;

				if ($forceUsage) {
					//case: всё равно добавляем версию
					if ($v === true) $v = static::$vdef;
					$vname = "v$v/$name";
				}

			}

		} else {
			$vname = false;
			
			//base case: static $vtpl = true;
			$v = static::$vdef;
			$vtpl = true;

			if (is_array($name)) {//case: site_vtpl('header', array('header', 0)),
				//case: указание на ручной запуск определённой версии
				list($name, $v) = $name;
			} else {
				//case: определение версии по конфигу
				if (is_array(static::$vtpl)) {
					$vtpl = prop(static::$vtpl, $name);
					if (is_string($vtpl)) { //case: 'header' => 'v1/header'),
						$vname = $vtpl;
					} else if ($vtpl === true) { //case: 'header' => true
						$v = static::$vdef;
					} else if (is_array($vtpl)) { //case: 'header' => array('header', 1),
						list($vtpl, $v) = $vtpl;
					} else if (is_integer($vtpl)){
						$v = $vtpl;
						$vtpl = true;
					}
				}

			}

			if (!$vname) {
				//построение версионного суб-пути для темплейта
				if ($v === true) $v = static::$vdef;
				if ($vtpl === true) $vtpl = $name;
				
				if (is_integer($v)) $v = "v{$v}";
				
				$vname = "$v/$vtpl";

				$rename = prop(static::$vname, $vname);
				//d($vname, $rename, $v, $vtpl);
				if (is_string($rename)) $vname = $rename;
			}
		}

		//d($vname, $tplCtx, $ext);
		return static::tpl($vname, $tplCtx, $ext);
	}


//= call
	static function call($subPath, $ctx = array(), $ext = 'inc'){
		$path = static::path($subPath, $ext);
		//dx($path, is_file($path));
		static::temp_push($ctx);
		$result = inc($path, INC_RES_AS_DATA);
		static::temp_pop();
		return $result;
	}
	static function hasCall($name, $ext = 'inc'){
		return is_file(static::path($name, $ext));
	}


//= helpers
	//class name
	static function nc($name = true, $subName = false){
		if ($name === true) $name = 'base';
		$map = static::cfg('nc');
		$n = prop($map, $name);
		if (!$n) $n = $name === 'base' ? static::cfg('rName'): static::nc(true, $name, false);
		if ($subName) $n .= "-$subName";
		return $n;
	}

	static function val($name = true/*, $subNameN*/){
		$args = func_get_args();
		array_unshift($args, 'val');
		return static::cfg($args);
	}


}

/*
   //declared in php/rw/_rw.class.php

function rw($name, $method = null/*, $arg1, $arg2* /){
	if ($R = _rw::name($name)) {
		$args = array_slice(func_get_args(), 2);
		return call_user_func_array(array($R, $method), $args);
	}

}
function rw_tpl($name, $tplName, $tplCtx = false, $fileExt = 'tpl.php'){
	return rw($name, 'tpl', $tplName, $tplCtx, $fileExt);
}
*/

