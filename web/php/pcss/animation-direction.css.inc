<? $val = isset($arg[1]) ? $arg[1] : '%s'; ?>
<? # https://developer.mozilla.org/ru/docs/Web/CSS/animation-direction ?>
-webkit-animation-direction: <?=$val?>; <? # Chrome 19 - 43.0, Safari 4.0 > ?>
-moz-animation-direction: <?=$val?>; <? # Firefox 5.0 - 16.0  ?>
-o-animation-direction: <?=$val?>; <? # Opera > 12.10 ?>
animation-direction: <?=$val?>; <? # IE > 10  ?>