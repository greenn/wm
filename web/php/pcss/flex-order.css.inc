<? $val = isset($arg[1]) ? $arg[1] : '%s'; ?>
<? if (!PCSS_DEV_MODE) { ?>
-webkit-flex-order: <?=$val?>;
-ms-flex-order: <?=$val?>;
<? } ?>
order: <?=$val?>;