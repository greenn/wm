<? $val = isset($arg[1]) ? $arg[1] : '%s'; ?>
<? # определяет сколько раз будет проигрываться анимационный цикл, перед тем как остановиться ?>
<? # https://developer.mozilla.org/ru/docs/Web/CSS/animation-iteration-count ?>
-webkit-animation-iteration-count: <?=$val?>; <? # Chrome < 43.0, Safari 4.0 > ?>
-moz-animation-iteration-count: <?=$val?>; <? # Firefox 5.0 - 16.0  ?>
-o-animation-iteration-count: <?=$val?>; <? # Opera > 12.10 ?>
animation-iteration-count: <?=$val?>; <? # IE > 10  ?>