<?  //http://the-echoplex.net/flexyboxes
    $val = isset($arg[1]) ? $arg[1] : '%s';
    $group = (integer)$val + 1;
?>
-webkit-box-ordinal-group: <?=$group?>;
-moz-box-ordinal-group: <?=$group?>;
-webkit-order: <?=$val?>;
-ms-flex-order: <?=$val?>;
order: <?=$val?>;