<? foreach (_css('ffs') as $n => $cfg) {
    $ff = $cfg[0]; //if (has_space) "'ffs'"
?>
*[class*="ft-"].-ff<?=$n?> {
    font-family: <?=$ff?>;
}
<? } ?>