<?  _needphp('strLess'); //http://the-echoplex.net/flexyboxes
    $val = isset($arg[1]) ? $arg[1] : '%s';
    $rawVal = strLess($val, 'flex-');
?>
<? if (!PCSS_DEV_MODE) { ?>
-webkit-box-pack: <?=$rawVal?>;
-moz-box-pack: <?=$rawVal?>;
-webkit-justify-content: <?=$val?>;
-ms-flex-pack: <?=$rawVal?>
<? } ?>;
justify-content: <?=$val?>;