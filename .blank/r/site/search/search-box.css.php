<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _site::self();
$nSB = $Self::nc('SB');

$tr = _css('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    //etag::extra(),
    __FILE__
));
?>

.ft-search-input {
    font-family: <?=_css('f1_')?>;
    color: <?=_css('tc-content')?>;
    font-size: 14px;
    font-weight: 400;
}

.<?=$nSB?>-field {
    margin-left: 3px;
    margin-right: 6px;

    padding: 4px 11px;
    border-radius: 15px;
    border: 1px solid <?='#afb0b4'?>;
}

.<?=$nSB?>-input {
    width: 100px;
}

.<?=$nSB?>.-focus .<?=$nSB?>-field {
    border-color: <?='#dcd9da'?>;

}
.<?=$nSB?>.-process .<?=$nSB?>--border {
    border-color: <?='#97a097'?>;
}
