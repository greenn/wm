<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
	'headers'
);

$Self = _rt::self();
$jsDir = $Self::relDir('page.js');
$js = array();

$nP = $Self::nc('page');

headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	$js['api'] = $Self::path("$jsDir/api.js.inc"),
	$js['app'] = $Self::path("$jsDir/app.js.inc"),
	$js['router'] = $Self::path("$jsDir/router.js.inc"),
	__FILE__
), SITE_CACHE);
?>

<? include $js['api'] ?>

<? include $js['app'] ?>

<? //include $js['router'] ?>