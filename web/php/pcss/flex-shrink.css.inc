<? $val = isset($arg[1]) ? $arg[1] : '%s'; ?>
<? if (!PCSS_DEV_MODE) { ?>
-webkit-flex-shrink: <?=$val?>;
<? } ?>
flex-shrink: <?=$val?>;