<? foreach (array(
    'thn' => 100, //Thin
    'elgt' => 200, //Extra-light
    'lgt' => 300, //Light
    'reg' => 400, //Regular (Normal, Book)
    'med' => 500, //Medium
    'sbld' => 600, //Semi-bold (Demi-bold)
    'bld' => 700, //Bold
    'ebld' => 800, //Extra-bold (Heavy)
    'blk' => 900, //Black
) as $cls => $val) {
    $cls1 = "fw-$cls";
    $cls2 = "fw-$val";
?>
    <? foreach (array($cls1, $cls2) as $nc) { ?>
        .<?=$nc?>,
        .<?=$nc?>_,
        .<?=$nc?>_ *,
        .<?=$nc?>_ *[class*="ft-"],
        *[class*="ft-"].<?=$nc?>,
        *[class*="ft-"] .<?=$nc?>,
        *[class*="ft-"].<?=$nc?>_,
        *[class*="ft-"].<?=$nc?>_ *,
        *[class*="ft-"] .<?=$nc?>_,
        *[class*="ft-"] .<?=$nc?>_ *,
    <? } ?>
    [fw-<?=$cls?>],
    [fw<?=$val?>],
    [fw="<?=$val?>"] {
        font-weight: <?=$val?>;
    }
<? } ?>