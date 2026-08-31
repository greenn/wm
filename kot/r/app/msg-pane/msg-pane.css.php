<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

$Self = _kot::self();
$n = $Self::nc();

//$tr = _cssKot('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),

    __FILE__
));
?>

.ft-kot-msg-pane {
	font-size: 12px;
	line-height: 10px;
	font-family: monospace;
}

.<?=$n?> {
	min-height: 200px;
}