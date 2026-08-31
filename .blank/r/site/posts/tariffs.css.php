<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _site::self();
$nT = $Self::nc('T');

$tr = _css('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

.ft-plan-head-title {
    font-family: <?=_css('f2_')?>;
    font-size: 30px;
    color: <?='#285563'?>;
    font-weight: 500;
}
.ft-plan-head-text {
    font-family: <?=_css('f2_')?>;
    font-size: 16px;
    color: <?='#012c49'?>;
    line-height: 20px;
    font-weight: 400;
}

.ft-plan-title {
    font-family: <?=_css('f3_')?>;
    font-size: 17px;
    text-transform: uppercase;
    color: <?='#4d5d68'?>;
    font-weight: 600;
}

.ft-plan-list {
    font-family: <?=_css('f1_')?>;
    font-size: 14px;
    color: <?=_css('white')?>;
    line-height: 21px;
    font-weight: 400;
}

.ft-plan-price {
    font-family: <?=_css('f3_')?>;
    font-size: 20px;
    color: <?='#285563'?>;
    font-weight: 500;
}

.ft-plan-price-button-label {
    font-family: <?=_css('f2_')?>;
    font-size: 20px;
    color: <?='#285563'?>;
    font-weight: 500;
}




    .ft-plan-text {
        font-family: <?=_css('f1_')?>;
        font-size: 16px;
        color: <?='#4d5d68'?>;
        line-height: 20px;
        font-weight: 300;
        font-style: italic;
    }

[indent="<?=$nT?>-after-"] { height: 30px; }



.<?=$nT?> {
    padding: 0 10px;
}


.<?=$nT?>-col {
    width: 50%;
    margin-bottom: 33px;
}

.<?=$nT?>-item-c {
    height: 270px;
    background-repeat: no-repeat;
    background-position: top center;
    background-image: url('<?=_i::uri('plans/3/v1.png')?>');
    background-size: contain;


}

.<?=$nT?>-item- {
    height: 240px;
    background-size: cover;
}
.<?=$nT?>-title {
    padding: 10px;
}

.<?=$nT?>-list {
    padding: 1px 37px;
}

.<?=$nT?>-list UL {
    list-style-position: inside;
    list-style-type: disclosure-open;
}

.<?=$nT?>-price {
    padding: 10px;
}
<?
    $n_LRB1 = lay('button', 'nc', 'RB1');
?>
.<?=$nT?>-price[price-mode="2"] .<?=$n_LRB1?> {
    padding: 11px 19px;
}

.<?=$nT?>-price[price-mode="2"] .<?=$nT?>-price-label {
    margin-top: 15px;
    margin-bottom: 15px;
}
