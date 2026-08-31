<?
$Self = _site::self();

?>
<? if (0) { ?> @import '<?=qv($Self::uri('loader.css.php'))?>'; <? } ?>
<? if (0) { ?>
    [indent="before-content"] { height: 10px; }
    [indent="after-content"] { height: 50px; }
    [indent][before="content"] { height: 10px; }
    [indent][after="content"] { height: 10px; }
<? } ?>

HTML {
    background-color: <?=_css('bg-main')?>;
}

<?

$ph_ = array(60, 42, 18);
$ph0_ = array(60, 42, 0);

?>


<?
/*
    концепт общих падингов для блоков
    pb - block-padding
        чтобы для MQ у блоков были б одинаковые/гармоничные отступы

*/

/* для указания 100% ширины с общим отступом
        желательно
        надо заменять на inner-wrapper
            <div class=" 100% ">
                <div class="site-p">…</div>
            </div>
*/
?>



.site-p {
    <?=pcss('transition', array(
        "padding $tr",
        "padding-left $tr",
        "padding-right $tr",
    ))?>
}


<? function dec_sitePad($p, $nc){ ?>
    .site-w.<?=$nc?>, <?// site-w со значением site-p  ?>
    .<?=$nc?> { <?// просто значения site-паддинга ?>
        padding-right: <?=$p?>px;
        padding-left: <?=$p?>px;
    }
    .site-w.<?=$nc?> {
        width: calc(100% - <?=($p * 2)?>px);
    }
<? } ?>

<? dec_sitePad($ph_[0], 'site-p') ?>
<? dec_sitePad($ph0_[0], 'site-p0') ?>

@media (max-width: <?=_css::mq(2)?>px) {
    <? dec_sitePad($ph_[1], 'site-p') ?>
    <? dec_sitePad($ph0_[1], 'site-p0') ?>
}

@media (max-width: <?=_css::mq(3)?>px) {
    <? dec_sitePad($ph_[2], 'site-p') ?>
    <? dec_sitePad($ph0_[2], 'site-p0') ?>
}

