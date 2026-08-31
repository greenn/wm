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
    margin-left: 6px;
    margin-right: 6px;
}

.<?=$n?>-sub-w { display: none }
.<?=$n?>-sub-w.-expanded { display: block }

.<?=$n?>-sub {
    padding-right: 16px;
    padding-left: 16px;

}

.<?=$n?>-item-sep {
    height: 2px;
}
.<?=$n?>-item-sep-line {
    background-color: <?=_cssKot('main-bg')?>;
    left: -6px;
    right: -6px;
}

.<?=$n?>-item A {
    text-decoration: none;
}

.<?=$n?>-link {
    padding: 12px 16px;
    cursor: pointer;
}
.<?=$n?>-link.nolink,
.<?=$n?>-link[nolink] {
    cursor: default;
}

.<?=$n?>-link-w.-border {
    border-left: 4px solid <?=_cssKot('menu-sub-border')?>;
    margin-left: -5px;
}


.<?=$n?>-toggle {
    cursor: pointer;
    <?=pcss('transition', 'transform 250ms ease') ?>
}

.<?=$n?>-link-w.-expanded .<?=$n?>-toggle {
    <?=pcss('transform', 'rotate(180deg)')?>
}

.<?=$n?>-link-w.-expanded .<?=$n?>-link {
    font-weight: bold;
}
.<?=$n?>-link-w.-selected.-nosub {
    background-color: <?=_cssKot('flash-white')?>;
}


.ft-menu {
    font-family: Roboto;
    font-size: 16px;
    color: rgba(0, 0, 0, 0.87);
}

@media (max-width: <?=_mq(2)?>px) {}