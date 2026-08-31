<?
    $Self = _rb::self();
    $_ctx = $Self::tempCtx(array(
        'method' => '_css',
    ));
    $method = $_ctx['method'];
?>
<? foreach ($method('ffs') as $name => $cfg) {
    $val = $cfg[0]; //if (has_space) "'ffs'"
    $cls1 = "ff-$name";
?>
    <? foreach (array($cls1) as $nc) { ?>
        .<?=$nc?>,
        .<?=$nc?>_,
        .<?=$nc?>_ *,
        .<?=$nc?>_ *[class*="ft-"],
        *[class*="ft-"].<?=$nc?>,
        *[class*="ft-"] .<?=$nc?>, <?// '?>
        *[class*="ft-"].<?=$nc?>_,
        *[class*="ft-"].<?=$nc?>_ *,
        *[class*="ft-"] .<?=$nc?>_,
        *[class*="ft-"] .<?=$nc?>_ *,
    <? } ?>
    [ff-<?=$name?>],
    [ff="<?=$name?>"] {
        font-family: <?=$val?>;
    }
<? } ?>