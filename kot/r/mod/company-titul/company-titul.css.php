<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

$Self = _kmod::self();
$n = $Self::nc();

//$tr = _cssKot('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

.<?=$n?> {
	background-color: lightyellow;
}
