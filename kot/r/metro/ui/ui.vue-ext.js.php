<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp(
	'headers'
);
$Self = _kot::self();
//$n = $Self::nc();

$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	//$js['provide/field-validate'] = $Self::path('provide/field-validate.b1.js.inc'),
	$js['provide/field-validate'] = $Self::path('provide/field-validate.js.inc'),
	__FILE__
), SITE_CACHE);
?>

<? include $js['provide/field-validate']; ?>