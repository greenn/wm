<?  _needphp('strLess');
    $val = isset($arg[1]) ? $arg[1] : '%s';
    $rawVal = strLess($val, 'flex-');
?>
<? if (!PCSS_DEV_MODE) { ?>
-webkit-align-self: <?=$val?>;
-ms-flex-item-align: <?=$rawVal?>;
<? } ?>
align-self: <?=$val?>;