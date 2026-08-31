<?
    $val = isset($arg[1]) ? $arg[1] : '%s';
    if (preg_match('~^[\w-]+$~', $val)) $val = cbn($val); //https://regex101.com/r/os0b0g/1
?>
<? # определяет как должна прогрессировать CSS анимация в течении каждого цикла ?>
<? # https://developer.mozilla.org/ru/docs/Web/CSS/animation-timing-function ?>
-webkit-animation-timing-function: <?=$val?>; <? # Chrome < 43.0, Safari 4.0 > ?>
-moz-animation-timing-function: <?=$val?>; <? # Firefox 5.0 - 16.0  ?>
-o-animation-timing-function: <?=$val?>; <? # Opera > 12.10 ?>
animation-timing-function: <?=$val?>; <? # IE > 10  ?>