<?
    $_FS = _css('fs_');
    $f0 = _css('f0');
    $f1 = _css('f1');
?>
<? foreach ($_FS as $id => $set) {
    if ($alt = prop($set, 'use_alt')) {
        $_alt = prop($set, 'alt', array());
        $set = array_replace($set, $_alt);
        $fw = prop($set, array('fw', 2), 400);
        //dx($set, $alt, $_alt, $fw);
    }
    $sr = $set[0];
    $fs = $set[1];
    $ff = prop($set, 'ff', "$f1, $f0");
    $fw = prop($set, array('fw', 2), 400);
    $fh = prop($set, 'fh');
    $fc = prop($set, 'fc', 'black');
    //if ($id === 'l-hg') dx($set);
    $ls = prop($set, 'ls');
?>
<?=$sr?> {
    font-family: <?=$ff?>;
    font-size: <?=$fs?>px;
    font-weight: <?=$fw?>;
    font-style: normal;
    <? if ($fc !== false) { ?>
        color: <?=_css($fc)?>;
    <? } ?>
    <? if ($fh) { ?>
        line-height: <?=$fh?>px;
    <? } ?>
    <? if ($ls) { ?>
        letter-spacing: <?=$ls?>px;
    <? } ?>
}
<?//MQ для fonts сразу после объявления
    if ($mq = prop($set, 'mq')) {
        if (isOrdinal($mq)) { dx($mq, $set); }
        foreach ($mq as $mqName => $fs) {
            //if (!is_string($fs))
    ?>
@media (max-width: <?=_css::mq($mqName)?>px) {
    <?=$sr?> {
        font-size: <?=$fs?>px;
    }
}
        <? } ?>
    <? } ?>

<? } ?>