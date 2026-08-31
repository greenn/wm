<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

$Self = _kot::self();
$nCN = $Self::nc('CN'); //clear-newline

$tr = _cssKot('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

.<?=$nCN?> {}


.<?=$nCN?> [area-w] {
    padding-top: 20px;
}

.<?=$nCN?> [area] {
    display: block;
    min-width: 400px;
    min-height: 120px;
}

.<?=$nCN?> [input] [area] {
    background-color: lightgoldenrodyellow;
}

.<?=$nCN?> [output] [area] {
    background-color: lightgreen;
    color: black;
    font-weight: 500;
}

.<?=$nCN?> [note] {
    /*font: 14px 500 monospace;*/
    font: 14px monospace;
    font-weight: 500;
}

.<?=$nCN?> [output] [note="success"] {
    color: darkgreen;
}




@media (max-width: <?=_mq(2)?>px) {}