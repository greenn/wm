<?// web framework: WEB #19.2.11  ?><? if (defined('WEB')) return; /* _*/?><?php

if (!isset($eOff) || !$eOff) error_reporting(-1);

if (true && 'show-all-errors') {
	//phpinfo();
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);
}

define('Online', true); //есть интернет
define('IP', $_SERVER['REMOTE_ADDR']);
function get_web_constants(){ //получить все WEB-константы в ввиде массива
	$list = array();
	$skip = true;
	foreach (get_defined_constants() as $name => $value) {
		if ($name === 'IP') $skip = false;
		if ($skip) continue;
		$list[$name] = $value;
	}
	return $list;
}

define('isLocalhost', in_array(IP, array('127.0.0.1', "::1")));

function isMe($v = '1'){
	$isMe = array();
	$isMe['s'] = (session_id() && isset($_SESSION['isMe'])) ? $_SESSION['isMe'] : null;
	$isMe['ck'] = isset($_COOKIE['isMe']) ? !!json_decode($_COOKIE['isMe']) : null;
	$isMe['ip'] = isLocalhost || in_array(IP, array(
		'185.239.48.28', //2025-03-24 (VPN)
		'176.59.20.100', //2025-03-24
	));
	$isMe['get'] = isset($_GET['me']) ? $_GET['me'] !== 'off' : null;
	$isMe['1'] = $isMe['get'] ?? $isMe['s'] ?? $isMe['ck'] ?? $isMe['ip'];
	//$isMe['1'] = !is_null($isMe['s']) ? $isMe['s'] : (!is_null($isMe['ck']) ? $isMe['ck'] : $isMe['ip']);

	//return false;
	return $isMe[$v];
}

//if (!session_id()) session_start(); //

define('isMe', isMe());
define('isUC', false && !isMe);

/*
    подготовка свдений о "даннои состоянии запуска"
        переменные запросы
        возможность включать доп. функциональность
*/
define('isDbg', isset($_COOKIE['dbg']));
define('ROOT', rtrim(isset($GLOBALS['ROOT']) ? $GLOBALS['ROOT'] : $_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR));
define('SSL', isset($_SERVER['HTTPS']) || isset($_SERVER['HTTP_HTTPS']) ? 's' : '');
define('HOST', $_SERVER['HTTP_HOST']);
define('hostName', preg_replace('~^www\.~', '', HOST)); #~
define('URI', $_SERVER['REQUEST_URI']);
define('domain', HOST);
define('hostProtocol', 'http'.SSL.'://');
define('hostUrl', hostProtocol.HOST);
define('domainUrl', hostUrl.'/'); //ak hostUrl_
define('URL', hostProtocol.HOST.URI);
define('pageUrl', strtok(URL, '?'));
define('pagePath', strtok(URI, '?'));
define('pageUri', trim(pagePath, '/'));
define('_pageUri', '/'.pageUri); //pageUri с ведущим слешем / полезно для сверки url
define('ROOTs', ROOT.DIRECTORY_SEPARATOR); //-
define('WEB', dirname(__FILE__));
define('WEBs', WEB.DIRECTORY_SEPARATOR); //-
define('PHP', WEB.'/php'); //mb WEB_PHP
define('LIB', WEB.'/lib');
define('INC', WEB.'/inc'); //mb WEB_LIB
define('osLinux', DIRECTORY_SEPARATOR == '/');
define('osWindows', DIRECTORY_SEPARATOR == '\\');

//eg: inc_inc('-d/p.u'); exit;
define('pageDir', substr(pagePath, -1) === '/' ? /*case: когда опущен /index.php = */pageUri : dirname(pageUri)); //
	define('pageDir_', pageDir.'/'); //tr
	define('_pageDir', '/'.pageDir); //0-tr
define('pageName', basename(pagePath));
//define('pageQuery', $_SERVER['QUERY_STRING']); //oz (в htaccess если rewite идёт с параметром, то здесь будут те параметры, а реальный pageQuery лучше брать от substr(URL, strpos(URL, '?') + 1);
define('pageQuery', strpos(URL, '?') ? substr(URL, strpos(URL, '?') + 1) : '');
define('pageQueryMark', pageQuery !== '' || (substr(URL, -1) === '?'));
define('pageQueryFull', (pageQueryMark ? '?' : '') . pageQuery);

$pageParts = explode('/', pageUri);
define('pageCount', count($pageParts));
foreach ($pageParts as $index => $pageName) {
	define('page'.($index + 1), $pageName);
}

//define('isMainDomain', domain === 'www.gettbot.io' || domain === 'gettbot.io'); //move to site-conf

define('SYS_ENCODING', 'UTF-8'); //Windows-1251
// mb_internal_encoding(SYS_ENCODING);

$lang = isset($SESSION) && isset($SESSION['SYS_LANG']) ? $SESSION['SYS_LANG'] : 'ru';
define('SYS_LANG', $lang);

define('SITE_LANG', isset($_REQUEST['lang']) ? $_REQUEST['lang'] : 'u'); //универсальный undefined
//define('SITE_TZ', ); //TIME_ZONE сайта


define('SITE_CACHE', //общее кеширование на сайте
    //'1h'
    //'cache-off'
    //isLocalhost ? true : '1h'
    //isMe ? 'cache-off' : true
    //'rand_1-3h' //|rand(h:1-3)|rand(h1-h3)|rand(h[1-3])
    true
);
define('SITE_ETAG_PEPPER', 1);


define('DS', DIRECTORY_SEPARATOR);
define('RN', "\r\n");

define('ARN', '&#013;'); //newLine для html-аттрибута (eg: title)
define('newline', PHP_EOL); //newline [fh not newLine | NewLine]
define('newline2', str_repeat(newline, 2));
define('tab', "\t"); //tab | TB
define('empty_string', ''); //empty-string | ES
define('space', ' '); //space | SP

	define('t', true);
	define('f', false);
	define('n', null);
	define('ts', 'true');
	define('fs', 'false');
	define('ns', 'null');

include_once PHP.'/need.php';
_lib('kint');
//dx(11);
