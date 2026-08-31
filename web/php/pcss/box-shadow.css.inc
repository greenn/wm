<?
    $val = isset($arg[1]) ? $arg[1] : '%s';
    if (is_array($val)) $val = join(', ', $val);
    $inset = isset($arg[2]) ? 'inset ' : '';

    //[horizontal offset] [vertical offset] [blur radius] [optional spread radius] [color]
    //ie: https://css-tricks.com/almanac/properties/b/box-shadow/

    //return print "box-shadow: $inset $val;";
?>
-moz-box-shadow: <?=$inset, $val?>; <?# 3.5(1.9.1) >< 4.0(2.0)?>
-webkit-box-shadow: <?=$inset, $val?>; <?# < webkit 5.1; C: < 4.0  ?>
box-shadow: <?=$inset, $val?>; <?# IE: 9 >; O: 10.5 >?>