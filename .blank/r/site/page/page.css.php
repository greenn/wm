<?
//oo rp-/app/page.css.php
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _site::self();
$n = $Self::nc();

$tr = _css('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

[indent="<?=$n?>-start"] {
    max-height: 70px;
    height: <?=_vw(70, 1800)?>;
}


[indent="<?=$n?>-end"] {
    max-height: 65px;
    height: <?=_vw(65, 1800)?>;
}

.<?=$n?> {

}


.bg-body {
    background: linear-gradient(to bottom, <?=pcss::gradientVal(
        array(0 => '#fefaf4', 30 => '#fcf9f3', 60 => '#fefaf4', 100 => '#fcf9f3')
    )?>);
}

@media (min-width: <?=_css::mq('max')?>px) {
    .bg-page {
        /*box-shadow: 3px 15px 37px -13px rgba(196, 180, 165, .4);*/
        box-shadow: 3px 15px 37px -13px rgb(49 71 83 / 60%);
    }

    .bg-page.mqr-w {
        overflow: hidden;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }
}





.bg-main {
    background: linear-gradient(to bottom, <?=pcss::gradientVal(
        //array(0 => '#f6f6f4', 65 => '#d6e1e4', 100 => '#b6cad1')
        array(0 => '#f6f6f4', 65 => '#d6e1e4', 100 => '#c4d5db')
    )?>);
}

.bg-content {
    background: linear-gradient(to bottom, <?=pcss::gradientVal(
        array(0 => '#fffef8', 70 => '#f7f6f2', 100 => '#f3f4f1')
    )?>);

    border-top-left-radius: 20px 15px;
    border-top-right-radius: 20px 15px;
    border-bottom-left-radius: 15px;
    border-bottom-right-radius: 15px;

    box-shadow: 12px 13px 7px -10px #9aa4a3;

}
