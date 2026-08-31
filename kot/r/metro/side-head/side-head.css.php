<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

$oo = gt_on('oo'); //dbg
$v6 = gt_on('v6', true); //by design

$Self = _kot::self();
$n = $Self::nc();


$tr = _cssKot('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>
<? if ($v6) { ?><? } ?>
<? if ($oo) { ?>
    .<?=$n?> > DIV {
        outline: 1px dashed springgreen;
    }
<? } ?>

.<?=$n?> {
    /*box-shadow: 0px 0px 0px 0px rgba(0, 0, 0, 0.2), 0px 0px 0px 0px rgba(0, 0, 0, 0.14), 0px 0px 0px 0px rgba(0, 0, 0, 0.12);
    box-shadow: 0px 3px 3px -2px rgba(0, 0, 0, 0.2), 0px 3px 4px 0px rgba(0, 0, 0, 0.14), 0px 1px 8px 0px rgba(0, 0, 0, 0.12);*/
}

.<?=$n?>-toggle {
    left: 100%;
    width: 25px;
    cursor: pointer;
}


@media (max-width: <?=_mq(2)?>px) {}