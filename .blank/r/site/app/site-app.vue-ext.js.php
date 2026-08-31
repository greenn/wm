<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
	'headers'//,
    //'dirUrl'
);
$Self = _site::self();

$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	$js['provide/mqr'] = rb('mqr', 'path', 'provider/v2/mqr.js.inc'),
	//etag::extra(),
	__FILE__
), SITE_CACHE);
?>

<? include $js['provide/mqr']; ?>

