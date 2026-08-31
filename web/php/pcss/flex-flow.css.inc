<?
    $val = isset($arg[1]) ? $arg[1] : '%s';
?>
<? if (!PCSS_DEV_MODE) { ?>
-webkit-flex-flow: <?=$val?>;
-ms-flex-flow: <?=$val?>; <?// nu?>
<? } ?>
flex-flow: <?=$val?>;