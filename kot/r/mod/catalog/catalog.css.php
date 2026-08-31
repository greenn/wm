<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

$Self = _kmod::self();
$nT = $Self::nc('T'); //tombs
$nTI = $Self::nc('TI'); //tombs-item

//$tr = _cssKot('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>


.<?=$nT?>-c {
    overflow: scroll;
    max-height: 72vh;
}

.<?=$nT?>-c {
	margin-top: 20px;
}
.<?=$nT?>-ci {
	border: 1px solid darkgrey;
	margin-right: 15px;
	margin-bottom: 15px;
    padding: 15px;
    width: 190px;
    height: 200px;
}