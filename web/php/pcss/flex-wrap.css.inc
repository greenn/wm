<?
    $val = isset($arg[1]) ? $arg[1] : '%s';
?>
<? if (!PCSS_DEV_MODE) { ?>
-webkit-flex-wrap: <?=$val?>;
-ms-flex-wrap: <?=$val?>;
<? } ?>
flex-wrap: <?=$val?>;