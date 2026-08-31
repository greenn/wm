<?#3.6.1 - page data
//oo ._/man/php/_page.class
_needphp(
	'inc',
	'dataPath',
	'fq/merge/join_values'
);

class _page {

	//кеш данных запрошенных страниц
	static $cache = array();
	static $defClass = 'page'; //003
	//static $defClass = 'lang_page';

	//кеш инстансов запрошенных страниц
	static $list = array();

	static function _pidNames($uriData){
		$pidData = is_array($uriData) ? $uriData : explode('/', trim($uriData, '/'));
		$pidIdn = join('/', $pidData);
		$pid = $pidData[0];
		return array($pid, $pidData, $pidIdn);
	}

	//добавить страницу как объект
	static function _add($pid, $data){
		//list($pid, $pidData, $pidUri) = static::_pidNames($pid);
		$page = false;
		if ($data) {
			$className = prop($data, 'className', static::$defClass);
			$page = new $className($data, $pid);  //new page
		}
		static::$list[$pid] = $page;
		static::$cache[$pid] = $data;
		return $page;
	}

	//получить страницу как объект
	static function get($pid){ //ak getData
		//list($pid, $pidData, $pidUri) = static::_pidNames($pid);
		if (!isset(static::$list[$pid])) {
			$data = static::loadData($pid);
			static::_add($pid, $data);
		}
		return static::$list[$pid];
	}

	static function pidFilePath($pid){
		$pagesDir = pro('configDir').'/pages';
		if (_x('hkIqPages')) $pagesDir = _x('hkIqPages');
		//dx($pagesDir);
		return $pagesDir."/$pid.inc";
	}

	static function hasPid($pid){
		//list($pid, $pidData, $pidUri) = static::_pidNames($pid);
		$fileName = static::pidFilePath($pid);
		return is_file($fileName);
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
		$path = pro('configDir').'/pages.inc';
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



	//ug: list($hasRel, $relUri, $isRel) = _page::hasRelUri($pid, true);
	static function hasRelUri($uri, $getData = false) {
		$pid = static::getUriPid($uri);
		if ($uri !== $pid) {
			$relUri = $uri;
			$hasRelUri = true;
		} else {
			$relUri = static::getUriPid($uri, true);
			$hasRelUri = $relUri !== $uri;
		}
		return $getData ? array($hasRelUri, $relUri, $relUri === $uri) : $hasRelUri;
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
	static function data($uri, $prop1 = false/*, $propN*/){
		$args = func_get_args();
		//if (_x('dbg1')) dx(static::getData($uri));
		$args[0] = static::getData($uri);
		return call_user_func_array("static::slice", $args);
		static::slice();
	}

	static function has_slice($data, $prop){
		$prop = (array) $prop;
		//d('has_slice', $prop, count($prop), $prop[0]);
		if (count($prop) == 1) {
			return array_key_exists($prop[0], $data);
		} else {
			return has_dataPath($prop, $data);
		}
	}
	static function slice($data, $prop1 = false/*, $propN*/){
		$prop = array_slice(func_get_args(), 1);
		if (!$data) return null;
		if ($data && $prop1) {
			if (count($prop) > 1) {
				//d($prop, $data);
				$data = dataPath($prop, $data);
			} else {
				$data = prop($data, $prop[0]);
			}
		}
		return $data;
	}


	/*static $cur_data = array();
	static function set_cur($prop, $value){
		static::$cur_data[$prop] = $value;
	}*/

	//формирование заголовка для вкладке в браузере
	static function pageTitle($text, $pattern = false){
		static $defPattern = array();
		if (!$defPattern) { //init pattern
			//$pattern['title-suffix'] = _pro('page-title-suffix');
			$defPattern['glue'] = _pro('page-title-glue');
			if (!$defPattern['glue']) $defPattern['glue'] = ' • ';
			$defPattern['title-suffix'] = _pro('base-title');
			if ($baseTitlePattern = _pro('base-title-pattern')) {
				//$defPattern['title-suffix'] = cur_iq(true, 'pro', 'dataPattern', $baseTitlePattern));
				$defPattern['title-suffix'] = pro::dataPattern($baseTitlePattern);
			}
		}

		if (!is_array($pattern)) $pattern = $defPattern;

		if ($text === true) {
			$text = cur_page('page-title'); //L
			if (!$text) $text = cur_page('title', 'page');
			//dx($text, cur_pid(), cur_page());
		}

		if ($text === false) {
			$title = $pattern['title-suffix'];
		} else {
			$rawTitle = cur_page('prop', 'raw-page-title'); //L
			if ($rawTitle) $rawTitle = cur_page('title', 'page-raw');

			if ($rawTitle) {
				if (is_string($rawTitle)) $title = $rawTitle;
			} else {
				if (!$text && !is_string($text)) {
					$text = pageUri;
				}

				$rawGlue = cur_page('prop', 'title-glue');
				$titleGlue = $rawGlue ? $rawGlue : $pattern['glue'];

				$title = join_values($titleGlue, array(
					$text,
					$pattern['title-suffix']
				));
			}

		}



		return $title;
	}



}



//вызов метода для инстнаса данных-страницы
function page($pid, $method = false/*, $arg1, $argN*/){
	//d($pid, $method, @func_get_arg(2));
	$Page = _page::get($pid);
	if ($Page) {
		if (!$method) {
			return $Page;
		} else {
			$method = array($Page, $method);

			if (is_callable($method)) {
				$args = array_slice(func_get_args(), 2);
				return call_user_func_array($method, $args);
			}
		}
	}
	return null;
}

//аллис для _page::data (получение данных страницы)
function _page($uri, $prop1 = false/*, $propN*/){
	return call_user_func_array('_page::data', func_get_args());
	_page::data();
}

/*
	cur_page('title', 'page');
*/
function cur_page() {
	$args = func_get_args();
	array_unshift($args, cur_pid());
	return call_user_func_array('page', $args);
}


/*
	ug

$data = _page::loadData($pid = 'terms-conditions');
dx($data, _page::slice($data, 'title', 'ru'));

$page = _page($pid = 'terms-conditions');
dx($page, _page($pid, 'title', 'en'));

$Page = page('terms-conditions');
dx($Page, $Page->lang('title'));
dx(page_lang('terms-conditions', 'title'))

$Page = page($pageName); dx($Page->lang('title'));

$pid = 'terms-conditions';
dx(page($pid, 'lang', 'title'));

page($pid, 'link'),
page('partnership-policy', 'link')
*/