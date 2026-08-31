<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
include_once $_SERVER['DOCUMENT_ROOT'].'/iq/test/vue/base/tt1/test-vue-base-tt1.class.php';
_needphp('headers');

$Self = _rt::name('test-vue-base-tt1');

$n = $Self::nc();

$tr = css('tr0');
headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));

?>

.<?=$n?> {
    background-color: lightyellow;
}