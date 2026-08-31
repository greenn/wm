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

[indent="<?=$n?>-begin"] { height: 10px; }
[indent="<?=$n?>-end"] { height: 10px; }

.<?=$n?> { background-color: orangered; }

@media (max-width: <?=_mq(2)?>px) {}