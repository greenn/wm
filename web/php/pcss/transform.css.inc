<?
$c = isset($arg[1]) ? $arg[1] : '%s';
if (is_array($c)) $c = join(' ', $c);
?>
-webkit-transform: <?=$c?>; <? # Edge, Safari { 3.1 >< 9.0 }, Chrome { 12.0 >< 36 }, Opera { 15.0 >< 23 } ?>
-moz-transform: <?=$c?>; <? # 3.5(1.9.1) >< 16.0(16.0) ?>
-o-transform: <?=$c?>; <? # 10.5 >< 12.10 ?>
-ms-transform: <?=$c?>; <? # 9.0 >< 10.10 ?>
transform: <?=$c?>;