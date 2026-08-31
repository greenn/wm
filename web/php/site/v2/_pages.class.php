<?/* 5.4.0 - менеджер страниц

	у каждого проекта свой менеджер

	имеет pid текущей страницы
	добавление данных страниц текущего проекта
	знанение о редиректах и rel-url
	получение данных страниц


	oo-lb ._/man/php/_page.class
*/
_needphp(
	'inc',
	'pathValue', //getValueByPath(); isPathExists()  // 'dataPath',
	'fq/merge/join_values'
);

//ak site_page
class _pages {

	static $proSid = true; //sid проекта

	static $list = array(); //кеш инстансов запрошенных страниц
	static $cache = array(); //кеш данных запрошенных страниц


	static $curUri;
	protected static $curPid = false;
	static function curUriSet($Uri = true){
		if ($Uri === true || is_string($Uri)) {
			$uri = $Uri;
			//case до установки curPid получаем данные текущей страницы
			$Uri = site_router::page_uri($uri, pro_opt_env('pages'));
			//$Page = $Uri->Page;
		}
		static::$curUri = $Uri;
		static::$curPid = $Uri->name;
	}
	static function curPid(){
		return static::$curPid;
	}
	static function curUri(...$args){
		$Uri = static::$curUri;
		if (!$args) {
			return $Uri;
		}

		$key = array_shift($args);

		if (property_exists($Uri, $key)) {
			if ($args) {
				return getValueByPath($Uri->$key, $args);
			} else {
				return $Uri->$key;
			}
		}

		if (method_exists($Uri, $key)) {
			return $Uri->$key(...$args);
		}

		dx('unknonwn curUri functionality');
	}


	//добавить страницу как объект
	static function _add($pid, $data){
		//d('_pages::_add', $pid, $data);
		$Page = new site_page($data, $pid, static::$proSid);  //new page
		static::$list[$pid] = $Page;
		static::$cache[$pid] = $data;
		return $Page;
	}

	//получить страницу как объект
	static function get($pid){ //ak getData
		if ($pid === true) $pid = static::$curPid;
		//list($pid, $pidData, $pidUri) = static::_pidNames($pid);
		if (!isset(static::$list[$pid])) {
			$data = static::loadData($pid);
			static::_add($pid, $data);
		}
		return static::$list[$pid];
	}


	static function pidFilePath($pid){
		$pagesDir = _pro(static::$proSid, 'pagesDir');
		return $pagesDir."/$pid.inc";
	}

	static function hasPid($pid){
		$fileName = static::pidFilePath($pid);
		//dx($pid, $fileName, is_file($fileName));
		return is_file($fileName);
	}

		static function hasPidOrData($pid){
			$hasPid = static::hasPid($pid);
			$hasData = isset(static::$cache[$pid]);
			return $hasPid || $hasData;
		}

	//получить данные страницы
	static function loadData($pid, $ctx = array()){
		//list($pid, $pidData, $pidUri) = static::_pidNames($pid);
		if (static::hasPid($pid)) {
			$fileName = static::pidFilePath($pid);
			return inc_data($fileName, array('pid' => $pid) + $ctx);
		}
		return false;
	}


	//получаем pid по uri
	static function getUriMap($uri = null) {
		$pagesDir = _pro(static::$proSid, 'pagesDir');
		$path = $pagesDir.'/.map.inc';
		return is_file($path) ? inc_data($path, array('uri' => $uri)) : array();
	}
	static function getUriPid($uri, $getPidUri = false) {
		static $uriMap = array();
		if (!$uriMap) $uriMap = static::getUriMap($uri);
		if ($getPidUri) { //case reverse
			//dx($uri, $uriMap, urldecode($uri));
			return array_search($uri, $uriMap) ?: $uri;
		} else {
			return prop($uriMap, $uri, $uri);
		}
	}


	//проверяем есть ли относительный url (перенаправляющий)
	//ug: list($hasRel, $relUri, $isRel) = _page::hasRelUri($pid, true);
	static function hasRelUri($uri, $extendedResponse = false) {
		$pid = static::getUriPid($uri);
		if ($uri !== $pid) {
			$relUri = $uri;
			$hasRelUri = true;
		} else {
			$relUri = static::getUriPid($uri, true);
			$hasRelUri = $relUri !== $uri;
		}
		return $extendedResponse ? array($hasRelUri, $relUri, $relUri === $uri) : $hasRelUri;
	}
	//static $verifyRelUri = true;
	static function _verifyRelUri(&$pageData, $uri){
		list($hasRelUri, $relUri) = static::hasRelUri($uri, true);
		$dpUri = array('link', 'uri'); //data-path к uri
		if ($hasRelUri && !_prop::has($pageData, $dpUri)) {
			$pageData = _prop::set($pageData, $dpUri, $relUri);
		}
	}

	//получить данные по странице
	static function getData($uri) {
		//d('_page::getData', $uri);
		//if (is_array($uri)) $uri = $uri[0];
		$pid = static::getUriPid($uri); //находим pid по Uri
		if (!isset(static::$cache[$pid])) {
			$pageData = static::loadData($pid);
			//static::_verifyRelUri($pageData, $uri);
			static::$cache[$pid] = $pageData;
		}
		//dx($pid, $pageData);
		return static::$cache[$pid];
	}

	//получить срез данных страницы
	//getDataSlice
	static function data($uri, ...$prop){
		$data = static::getData($uri);
		return getValueByPath($data, $prop);
	}

	function get_data($uri, $prop, $otherwise = null) {
		$data = static::getData($uri);
		if (isPathExists($data, $prop)) {
			return getValueByPath($data, $prop);
		}
		return $otherwise;
	}

}