
<? foreach (array(
    'wt' => 'white',
    'bl' => 'black',
    '1' => 'c1',
    '2' => 'c2',
) as $cls => $val) {
    //$cls = "-$cls";
    $cls = "c-$cls";
?>
*[class*="ft-"].<?=$cls?>,
*[class*="ft-"] .<?=$cls?> {
    color: <?=_css($val)?>;
}
<? } ?>
