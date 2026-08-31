<?
$c = isset($arg[1]) ? $arg[1] : '%s';
?>
-webkit-animation-play-state: <?=$c?>; <? # Chrome < 43?>
-moz-animation-play-state: <?=$c?>; <? # 5 >< 16 ?>
-o-animation-play-state: <?=$c?>; <? # < 12 ?>
animation-play-state: <?=$c?>; <? # ie > 10?>