<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _site::self();
$nPH = $Self::nc('PH');

$tr = _css('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>


.ft-phone-header-title {
    font-family: <?=_css('f2_')?>;
    font-size: 18px;

    font-weight: 500;
    color: <?=_css('tc-base')?>;
}
.ft-phone-header-title-sub {
    font-family: <?=_css('f3_')?>;
    font-size: 20px;
    font-weight: 400;
    color: <?=_css('tc-base')?>;
}

.ft-phone-header {
    font-family: <?=_css('f2_')?>;
    font-size: 22px;
    font-weight: 500;
    color: <?=_css('tc-base')?>;
}


.<?=$nPH?> {
    margin-bottom: 20px;
}

.<?=$nPH?>-col {
    padding-right: 10px;
}


.<?=$nPH?>-phone-icon {
    margin-left: -3px;
    opacity: .7;
    <?=pcss('transition', array(
        "opacity $tr",
    ))?>
}
    .<?=$nPH?>-phone-icon:hover {
        opacity: 1;
    }

.<?=$nPH?>-phone-icon.-first {
    margin-left: 3px;
}

.<?=$nPH?>-phone-icon IMG {
    height: 31px;

}
.<?=$nPH?>-phone-icon.telegram IMG {
    height: 41px;
}

.<?=$nPH?>-title-sub {

}

.<?=$nPH?>-phone [code] {
    margin: 0 3px;
}