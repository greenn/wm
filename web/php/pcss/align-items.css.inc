<?  _needphp('strLess'); //http://the-echoplex.net/flexyboxes
    $val = isset($arg[1]) ? $arg[1] : '%s';
    $rawVal = strLess($val, 'flex-');
?>
<? if (!PCSS_DEV_MODE) { ?>
-webkit-box-align: <?=$rawVal?>;
-moz-box-align: <?=$rawVal?>;
-webkit-align-items: <?=$val?>;
-ms-flex-align: <?=$rawVal?>;
<? } ?>
align-items: <?=$val?>;