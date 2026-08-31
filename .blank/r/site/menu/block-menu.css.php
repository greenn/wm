<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
_needinc('css/hex-rgb');

$Self = _site::self();
//$n = $Self::nc();
$nB = $Self::nc('block-menu');

$tr = _css('tr0');
//$oo = gt_on('oo'); //dbg

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    //etag::extra(),
    __FILE__
));
?>
.ft-menu-block {
    font-family: <?=_css('f1_')?>;
    font-size: 12px;
    text-transform: uppercase;
    color: <?='#4d5d68'?>;
    line-height: 17px;
    font-weight: 600;
}

.<?=$nB?>-menu:hover .ft-menu-block {
    font-weight: 700;
}


.<?=$nB?>-menu {
    margin-bottom: 30px;

    box-shadow: 5px 17px 12px -12px #9aa4a3;
}


.<?=$nB?>-link {
    background-color: <?='#fefaf4'?>;
    padding: 10px;
}


.<?=$nB?>-pic-w {
    overflow: hidden;
}
.<?=$nB?>-pic {
    height: 200px;
    background-repeat: no-repeat;
    background-position: 50%;
    background-size: auto 200px;


    <?=pcss('transition', array(
        //"transform $tr",
        //"transform 0.3s ease",
        "transform 0.7s ease",
    ))?>
    transform-origin: center;

}

.<?=$nB?>-menu[size="2"] .<?=$nB?>-pic {
    height: 250px;
    background-size: auto 250px;
}

.<?=$nB?>-menu:hover .<?=$nB?>-pic {
    <?=pcss('transform', 'scale(1.1)')?>;
}
.<?=$nB?>-menu[hover="2"]:hover .<?=$nB?>-pic {
    <?=pcss('transform', 'scale(1.1) rotate(1deg)')?>;
}

.<?=$nB?>-cover {
    <?// https://coolors.co/c8d5dc-e3eff6-a2bdcf-cce7f7-cee4ed-f4f6f6-7d98a8?>
    /* background-color: <?=hex2rgb('#7d98a8', .33)?>; */
    background-color: <?='#7d98a8'?>;
    opacity: .23;
    <?=pcss('transition', array(
        "opacity $tr",
    ))?>
}

.<?=$nB?>-menu:hover .<?=$nB?>-cover {
    opacity: 0;
}