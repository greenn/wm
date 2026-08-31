<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
	'headers'
);
$Self = _lay::self();
$n = $Self::nc();

//$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	//etag::extra(),
	//$js['parallax'] = $Self::path('parallax', 'js.inc'),
	__FILE__
), SITE_CACHE);
?>
$(function(){

});