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


.ft-copyright {
    font-family: <?=_css('f1_')?>;
    font-size: 13px;
    font-weight: 600;
}