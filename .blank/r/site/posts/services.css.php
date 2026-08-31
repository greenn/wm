<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _site::self();
$nS = $Self::nc('S');

$tr = _css('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>


.ft-service-head-title {
    font-family: <?=_css('f2_')?>;
    font-size: 30px;
    color: <?='#012c49'?>;
    font-weight: 500;
}

.ft-service-head-text {
    font-family: <?=_css('f2_')?>;
    font-size: 16px;
    color: <?='#012c49'?>;
    line-height: 20px;
    font-weight: 400;
}


.ft-service-title {
    font-family: <?=_css('f1_')?>;
    font-size: 14px;
    text-transform: uppercase;
    color: <?='#4d5d68'?>;
    font-weight: 700;
}

.ft-service-text {
    font-family: <?=_css('f1_')?>;
    font-size: 16px;
    color: <?='#4d5d68'?>;
    line-height: 20px;
    font-weight: 300;
    font-style: italic;
}

[indent="<?=$nS?>-after-"] { height: 30px; }

.<?=$nS?>-col {
    width: 33%;
    margin-bottom: 25px;
}

.<?=$nS?>-item {
    padding: 0 20px;
}

.<?=$nS?>-pic-w {

}

<?
    $s = 118; //124
    $s_i = floor($s * .88);
    $s_sh = floor($s * .8);

?>

.<?=$nS?>-pic-sh {
    width: <?=$s_sh?>px;
    height: <?=$s_sh?>px;
    border-radius: <?=floor($s_sh /2)?>px;

    box-shadow: -18px 20px 16px 2px rgb(0 109 137 / 14%);

}


.<?=$nS?>-pic {
    width: <?=$s?>px;
    height: <?=$s?>px;
    border-radius: <?=floor($s /2)?>px;

    background-image: url('<?=_i::uri('services/1-bg.png')?>');
    background-repeat: no-repeat;
    background-position: center center;
    background-size: cover;

    box-shadow: -12px 9px 15px 0px rgb(0 109 137 / 14%);

}

.<?=$nS?>-pic:after,
.<?=$nS?>-pic:before {
    content: ''; position: absolute; left: 0; top: 0; right: 0; bottom: 0;
    z-index: 10;
    border-radius: <?=floor($s /2)?>px;

}
.<?=$nS?>-pic:after {
    box-shadow: inset -23px 18px 11px -17px rgba(255,255,255,0.5);
    background-image: radial-gradient(circle at center, #ffffff 10%, rgba(255, 255, 255, 0) 70%);
}
.<?=$nS?>-pic:before {
    box-shadow: 3px -8px 12px 0px rgb(237 232 232 / 40%)
}

.<?=$nS?>-pic IMG {
    max-height: <?=$s_i?>px;
    max-width: <?=$s_i?>px;
    z-index: 20;
}

.<?=$nS?>-pic {
    margin-bottom: 20px;
}

.<?=$nS?>-title {
    margin-bottom: 10px;
}