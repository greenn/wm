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

.<?=$nCS?> {
	display: inline-block;
	border: 1px solid crimson;
	padding: 5px;
	margin: 10px;
}

