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
    $cls = "w-$cls"
?>
[fw<?=$val?>],
[fw="<?=$val?>"],
*[class*="ft-"].<?=$cls?>,
*[class*="ft-"] .<?=$cls?>,
*[class*="ft-"].<?=$cls?>_,
*[class*="ft-"].<?=$cls?>_ *,
*[class*="ft-"] .<?=$cls?>_,
*[class*="ft-"] .<?=$cls?>_ * {
    font-weight: <?=$val?>;
}
<? } ?>
