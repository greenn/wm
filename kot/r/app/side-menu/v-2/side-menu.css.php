<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

$oo = gt_on('oo'); //dbg
//$v6 = gt_on('v6', true); //by design

$Self = _kot::self();
$n = $Self::nc();

$tr = _cssKot('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>


<? if ($oo) { ?>
    .<?=$n?> {
        outline: 1px dashed deepskyblue;
    }
<? } ?>


.ft-side-button,
.ft-side-link {
    color-: rgba(0, 0, 0, 0.87);
    font-size: 12px;
    font-family: Roboto;
    font-weight: 500;
}


.<?=$n?> {
    padding: 6px;
}

.<?=$n?>-item-w {
    margin-bottom: 10px;
}

.<?=$n?>-item A {
    text-decoration: none;
}

.<?=$n?>-link {
    padding: 3px 4px;
}
.<?=$n?>-link.nolink {
    cursor: default;
}


.<?=$n?>-toggle {
    <?=pcss('transition', 'transform 250ms ease') ?>
}
.<?=$n?>-toggle [icon] {
    cursor: pointer;
    font-size: 15px;
    font-weight: 700;
    font-variation-settings: 'wght' 700;
}

.<?=$n?>-button {
    margin-top: -1px;
    padding-right: 3px;
    padding-left: 3px;
    height: 21px;
}
.<?=$n?>-button [icon-w] {
    margin-right: 5px;
}
.<?=$n?>-button [icon] {
    font-size: 15px;
}


.<?=$n?>-item.-expanded .<?=$n?>-toggle {
    <?=pcss('transform', 'rotate(90deg) translateY(3px)')?>
}



.<?=$n?>-sub-w { display: none }
.<?=$n?>-sub-w.-expanded { display: block }

.<?=$n?>-sub {
    margin-left: 10px;
    padding-left: 5px;
    padding-right: 0px;
}
.<?=$n?>-sub .<?=$n?>-item-w {
    margin-bottom: 1px;
}
.<?=$n?>-sub .<?=$n?>-link {
    padding: 2px 2px;
}





@media (max-width: <?=_mq(2)?>px) {}