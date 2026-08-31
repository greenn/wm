<?#0.5.6
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
$selfDir = dirname(__FILE__);

$body = false;
$mount = 'BODY';

$vueCtx = kot('test', 'url2ctx', strLess(pageUri, 'kot/r-test'));
//dx($vueCtx);

$contentPath = false;
$contentPath1 = "$selfDir/{$vueCtx['rName']}.tpl.inc";
$contentPath2 = "$selfDir/{$vueCtx['rName']}/{$vueCtx['tplName']}.tpl.inc";

if (is_file($contentPath1)) $contentPath = $contentPath1;
else if (is_file($contentPath2)) $contentPath = $contentPath2;

//dx($contentPath1, is_file($contentPath1), $contentPath2, is_file($contentPath2));

if (is_file($contentPath)) {
	ob_start();
	include $contentPath;
	$body = ob_get_clean();
}

//dx($body, $vueCtx);

$pageCtx = array();
$pageCtx['mount'] = $mount;

if ($body) {
	$pageCtx['body'] = $body;
} else {
	$pageCtx['vue'] = $vueCtx;
}

print kot_tpl('test', 'page', $pageCtx);