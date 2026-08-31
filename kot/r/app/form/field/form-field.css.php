<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

$Self = _kot::self();
$n = $Self::nc();

//$tr = _cssKot('tr0');

$css = array();
$cssDir = $Self::path(); //same $Self::relDir();
headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    $css['blank'] = "$cssDir/blank.css.inc",
    __FILE__
));
?>
<? include $css['blank'] ?>