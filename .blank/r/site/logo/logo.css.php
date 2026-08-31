<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _site::self();
$n = $Self::nc();
$nH = $Self::nc('header');

$tr = _css('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

.ft-logo {
    font-family: <?=_css('f1_')?>;
    font-size: 18px;
    line-height: 19px;
    font-weight: 600;
    color: <?=_css('tc-base')?>;
}

.ft-logo-abbr {
    font-family: <?=_css('f1_')?>;
    font-size: 20px;
    font-weight: 600;
    color: <?=_css('tc-base')?>;
}


.ft-logo [part="1"]{
    font-size: 20px;

}

.<?=$nH?>-pic IMG {
    height: 34px;
}

.<?=$nH?>-pic {
    margin-right: 20px;
}

.<?=$nH?>-title SPAN {
    display: block;
}