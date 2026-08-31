<?  //http://the-echoplex.net/flexyboxes
    $val = isset($arg[1]) ? $arg[1] : '%s';
    $valParts = explode(' ', $val);
    $shortVal = $valParts[0];
?>
<?// display: table-cell; //ie9+ //https://stackoverflow.com/questions/24371408/flexbox-alternative-for-ie9?>
<? if (!PCSS_DEV_MODE) { ?>
-webkit-box-flex: <?=$shortVal?>;
-moz-box-flex: <?=$shortVal?>;
-webkit-flex: <?=$val?>;
-ms-flex: <?=$val?>;
<? } ?>
flex: <?=$val?>;