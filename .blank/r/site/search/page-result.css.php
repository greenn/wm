<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _site::self();
$nPR = $Self::nc('PR');

$tr = _css('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    //etag::extra(),
    __FILE__
));
?>

.ft-search-input {
    font-family: <?=_css('f2_')?>;
    color: <?=_css('tc-content')?>;
    font-size: 18px;
    font-weight: 300; <?//NAMU 1750?>
}

.ft-search-label-button {
    font-family: <?=_css('f2_')?>;
    color: <?=_css('tc-content')?>;
    font-size: 18px;
    font-weight: 900; <?//NAMU 1930?>
}

.<?=$nSB?>.-focus .ft-search-label-button {
    -color: <?=_css('c1')?>;
}

.ft-search-label-result {
    font-family: <?=_css('f2_')?>;
    color: <?=_css('tc-content')?>;
    font-size: 18px;
    font-weight: 900; <?//NAMU 1930?>
}






.<?=$nSB?>-field {
    margin-left: 3px;
    margin-right: 6px;
}
.<?=$nSB?>-input {
    top: -3px;
}


.<?=$nSB?>-input-border {
    bottom: -2px;
    height: 2px;
    background-color: <?=_css('tc-content')?>;

    <?=pcss('transition', array(
        "background-color $tr",
    ))?>
}

.<?=$nSB?>.-focus .<?=$nSB?>-input-border {
    background-color: <?=_css('c1a')?>;
}
.<?=$nSB?>.-process .<?=$nSB?>-input-border {
    background-color: <?=_css('c2')?>;
    background-color: <?=_css('c2a')?>;
}

.<?=$nSB?>-result {
    margin-left: 32px;
    margin-top: 4px;
}

.<?=$nSB?>-result-label {
    margin-right: 4px;
}

@media (max-width: <?=_mq(2)?>px) {}