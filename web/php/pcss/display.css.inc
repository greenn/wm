<? $arg;
    $val = isset($arg[1]) ? $arg[1] : '%s';

    //http://the-echoplex.net/flexyboxes
?>
<?if ($val === 'flex') { ?>
    <? if (!PCSS_DEV_MODE) { ?>
display: -webkit-box;
display: -moz-box;
display: -ms-flexbox;
display: -webkit-flex;
    <? } ?>
display: flex;
<? } else if ($val === 'inline-flex') { ?>
    <? if (!PCSS_DEV_MODE) { ?>
display: -webkit-box;
display: -moz-box;
display: -ms-inline-flexbox;
display: -webkit-inline-flex;
    <? } ?>
display: inline-flex;
<? } else { ?>
display: <?=$val?>;
<? } ?>