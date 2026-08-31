<? #3.4.0
//oo rp-/app/page.css.php
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _site::self();

$tr = _css('tr0');

rb('mqr', 'req_css', 'mqr');


headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

.site-ww,
.site-w {
    width: 100%;
    min-width: <?=_css::mq('min')?>px;
    max-width: <?=_css('site-w')?>px; <?// ограничитель на расширение для 100% ?>
    display: table;
    margin: 0 auto;

    <?=pcss('transition', array(
        "width $tr",
        "margin $tr",
        "padding-left $tr",
        "padding-right $tr",
    ))?>
}

.site-ww {
    display: block;
    max-width: <?=_css::mq('max')?>px;
}

<? $ph = _css('site-ph') ?>

.site-p {
    <?=pcss('transition', array(
        "padding $tr",
        "padding-left $tr",
        "padding-right $tr",
    ))?>

    padding-right: <?=$ph?>px;
    padding-left: <?=$ph?>px;
}

.site-w.site-p {
    width: calc(100% - <?=($ph * 2)?>px);
}

