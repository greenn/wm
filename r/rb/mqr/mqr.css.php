<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

//$Self = _rb::self();

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    //etag::extra(),
    __FILE__
));
?>

.mqr-w {
    position: relative;
    margin: 0 auto;
    /*display: table;*/
    width: 100%;
}
.mqr-w > * {
    <?=pcss('transform-origin', 'left top')?>
}
