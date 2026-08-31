<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
//$rDir = dirname(dirname(__FILE__));
include_once $_SERVER['DOCUMENT_ROOT'].'/iq/tool/man/tool-man.class.php';
_needphp('headers');

$Self = _rw::name('admin');
//$nAp = $Self::nc('app');
headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    //etag::extra(),
    __FILE__
));
?>