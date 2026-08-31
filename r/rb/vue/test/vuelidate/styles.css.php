<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _rb::self();
$nCS = $Self::nc('cmpt-slot');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

H1 {
	padding: 5px;
	margin: 10px;
    background-color: navajowhite;
}

