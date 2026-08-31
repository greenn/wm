<?
$c = isset($arg[1]) ? $arg[1] : '%s';
?>
-webkit-transform-origin: <?=$c?>; <? # Edge, Safari, Chrome ?>
-moz-transform-origin: <?=$c?>; <? # 3.5(1.9.1) >< 10(10) ?>
-o-transform-origin: <?=$c?>; <? # 10.5 >< 12.10 ?>
-ms-transform-origin: <?=$c?>; <? # 9.0 >< 10.10 ?>
transform-origin: <?=$c?>;