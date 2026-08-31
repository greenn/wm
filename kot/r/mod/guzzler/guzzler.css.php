<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

$Self = _kmod::self();
$nM = $Self::nc('main');

//$tr = _cssKot('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

.<?=$nM?>-textarea {
	height: 600px;
}

.<?=$nM?>-textarea TEXTAREA {
    width: 100%;
    height: 100%;
}

.<?=$nM?>-busy {
	background-color: grey;
    opacity: .4;
}
