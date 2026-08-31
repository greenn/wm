<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _site::self();
$nIo = $Self::nc('Io');

$tr = _css('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>


.ft-contacts-label{
    font-family: <?=_css('f2_')?>;
    font-size: 18px;
    font-weight: 500;
    color: <?=_css('tc-base')?>;
}
.ft-contacts-tex {
    font-family: <?=_css('f3_')?>;
    font-size: 20px;
    font-weight: 400;
    color: <?=_css('tc-base')?>;
}

.<?=$nIo?>-phone [code] {
    margin: 0 3px;
}

.<?=$nIo?>-email {
    margin-left: 2px;
}

.<?=$nIo?>-phone [code] {
    margin: 0 6px;
}


.<?=$nIo?>-item {
    padding: 10px 0;
}

.<?=$nIo?>-label {
    margin-right: 12px;
}
.<?=$nIo?>-label:after {
    content: ':';
}

.<?=$nIo?>-text {
    margin-top: 1px;
}