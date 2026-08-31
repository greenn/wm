<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Root = _rt::name('root');
//dx(is_file($Root::path($Root::relDir('seo-keywords.class.inc'))));
include_once $Root::path($Root::relDir('app-busy.class.inc'));

$Self = _rt::name('app-busy');

$n = $Self::nc();

$tr = css('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

.<?=$n?>-item {
	margin: 20px;
	border: 1px solid grey;
	padding: 15px;
}
