<? $val = isset($arg[1]) ? $arg[1] : '%s'; ?>
<? if (!PCSS_DEV_MODE) { ?>
-webkit-align-content: <?=$val?>;
-ms-flex-line-pack: <?=$val?>;
<? } ?>
align-content: <?=$val?>;