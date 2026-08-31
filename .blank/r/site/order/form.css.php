<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _site::self();
$nF = $Self::nc('F');
$nFd = $Self::nc('Fd');

$tr = _css('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    //etag::extra(),
    __FILE__
));
?>

.ft-form-input {
    font-family: <?=_css('f2_')?>;
    color: <?=_css('tc-content')?>;
    font-size: 16px;
    font-weight: 300; <?//NAMU 1750?>
}

.ft-form-label {
    font-family: <?=_css('f2_')?>;
    color: <?=_css('tc-content')?>;
    font-size: 16px;
    font-weight: 500;
}

.<?=$nFd?>.-focus .ft-search-label-button {
    -color: <?=_css('c1')?>;
}

<?//                    form                   //?>

.<?=$nF?>-item {
    margin-bottom: 10px;
}


<?//                    field                   //?>

.<?=$nFd?>-field {
    margin-left: 15px;
    margin-right: 6px;
    padding: 10px 3px;
}
.<?=$nFd?>-input {
    width: 260px;
}

.<?=$nFd?>-input-border {
    left: 0px;
    bottom: 8px;
    height: 2px;
    background-color: <?=_css('tc-content')?>;

    <?=pcss('transition', array(
        "background-color $tr",
    ))?>
}

.<?=$nFd?>.-focus .<?=$nFd?>-input-border {
    background-color: <?='#4894ca'?>;
}
