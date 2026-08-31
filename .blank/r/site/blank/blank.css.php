<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _site::self();
$n = $Self::nc();

$tr = _css('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>
[indent="<?=$n?>-after"] { height: 30px; }

.<?=$n?> { background-color: orangered; }