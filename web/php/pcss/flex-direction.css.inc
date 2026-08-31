<?  _needphp('str'); //http://the-echoplex.net/flexyboxes
    $val = isset($arg[1]) ? $arg[1] : '%s';
    $orient = startsWith($val, 'column') ? 'vertical' : 'horizontal';
    $direction = endsWith($val, 'reverse') ? 'reverse' : 'normal';
?>
<? if (!PCSS_DEV_MODE) { ?>
-webkit-box-direction: <?=$direction?>;
-moz-box-direction: <?=$direction?>;
-webkit-box-orient: <?=$orient?>;
-moz-box-orient: <?=$orient?>;
-webkit-flex-direction: <?=$val?>;
-ms-flex-direction: <?=$val?>;
<? } ?>
flex-direction: <?=$val?>;