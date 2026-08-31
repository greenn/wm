<?/*#5.5.0 - вывод страницы,
	через rb('page', 'page', $pageCtx)
*/

//dx($rbPageCtx);
if (!1 && 'dbg') {
	phpinfo();
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);
	dx(_source::html_export());
}


$Self = _site::self();

//step: add css
_rb::req_css(-3, 'css', 'aq'); # r/rb/css/aq.css.php
_rb::req_css(-3, 'css', 'flex'); # r/rb/css/flex.css.php
_site::req_css(-2, 'css', 'ft'); # r/site/css/ft.css.php
_site::req_css(-1, 'css', 'site'); # r/site/css/site.css.php

//step: add js
//site('js', 'req_js', -2, 'site'); # r/site/js/site.js.php
//$Self::req_js(-1, 'page');

//step: add lib
rb('aos', 'req', false);
	//iq/php/iq.class.php:458
	//r/rb/aos/aos.class.inc:40




$_ctx = $Self::tempCtx(array(
	'body' => '', //html тело
	'page' => '', //extend rbTplCtx
	'app' => false,

	'og' => false,
	'favicon' => true,
));
$body = $_ctx['body'];
$app = $_ctx['app'];
$pageCtx = $_ctx['page'];
//dx(cur_page());

site('app', 'handleAppCtx', $app);
    //req_js site-app; collectStylesInBody
    //req_js app-env

$og = $Self::og($_ctx['og']);
$favicon = $Self::favicon($_ctx['favicon']);

$rbPageCtx = array(
	'body' => $body,
	'nc' => 'bg-body',
	'webkit' => $Self::webkit(),
	'raw-source' => join(newline2, array(
		_css::fontsLinks(),
		//rb('aos', 'init_js', true, true)
	)),

	'pageTitle' => true,

	//'og' => $og,
	//'favicon' => $favicon,
	'favicon' => '/kot/img/favicon/icons8-pet-commands-summon-96.png',
);

if (is_array($pageCtx)) {
	$rbPageCtx = array_replace_recursive($rbPageCtx, $pageCtx);
}

if ($rbPageCtx['pageTitle'] === true) {
	$rbPageCtx['pageTitle'] = _page::pageTitle(true);
}

print rb_tpl('page', 'page', $rbPageCtx);
