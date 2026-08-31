<?#3.2.1
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

//dx(urlVersion::$db_path, urlVersion::$db);

$requestUri = strLess(pageUri, 'wd/');
//dx($requestUri, pageUri);

//$presetName = str_replace("/", '-', $requestUri); #LP

$extend = array();
if (gt_on('embody')/*L*/ || gt_on('res')) $extend['just-embody'] = true;

//cur_lang(gt_has('en') ? 'en' : 'ru');


$ctx = rb('wd', 'preset_ctx', $requestUri, $extend);
//dx($ctx);

$body = rb_tpl('wd', 'wd', $ctx);
//dx(css::url_export());
//dx(_source::html_export());

if (false && '01') {
	$specOutput = dirname(__FILE__).'/'.prop($ctx, 'output').'.php';
	if (is_file($specOutput)) {
		include $specOutput;
		exit;
	}
}

$extendCtx = prop($ctx, 'html-ctx', array());

if (prop($ctx, 'html') === 'rb') {
	_rb::req_css(-3, 'css', 'aq'); # r/rb/css/aq.css.php
	_rb::req_css(-3, 'css', 'flex'); # r/rb/css/flex.css.php
	_rb::req_css(-1, 'css', 'reset'); # r/rb/css/css/reset.css.php

	$pageCtx = array(
		'body' => $body,
	);
	if ($extendCtx) {
		$pageCtx = array_replace_recursive($pageCtx, $extendCtx);
	}

	print rb_tpl('page', 'page', $pageCtx);
	exit;
}


//case base: //default
$pageCtx = array(
	'body' => $body,
	'app' => array(
		'mq' => 'off'
	),
);
if ($extendCtx) {
	$pageCtx = array_replace_recursive($pageCtx, $extendCtx);
}
//dx($pageCtx, $extendCtx);

$rMain = cur_opt('rMain');
//dx($rMain);

print _r_tpl_($rMain, 'page', 'html', $pageCtx);

//print site_tpl('page', 'html', $pageCtx);
