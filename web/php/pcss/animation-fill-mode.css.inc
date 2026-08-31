<? $val = isset($arg[1]) ? $arg[1] : '%s'; ?>
<? # как нужно применять стили к объекту анимации до и после ее выполнения ?>
<? # https://developer.mozilla.org/ru/docs/Web/CSS/animation-fill-mode ?>
-webkit-animation-fill-mode: <?=$val?>; <? # Chrome < 43.0, Safari 4.0 > ?>
-moz-animation-fill-mode: <?=$val?>; <? # Firefox 5.0 - 16.0  ?>
-o-animation-fill-mode: <?=$val?>; <? # Opera > 12.10 ?>
animation-fill-mode: <?=$val?>; <? # IE > 10  ?>