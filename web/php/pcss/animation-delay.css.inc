<? $val = isset($arg[1]) ? $arg[1] : '%s'; ?>
<? # Задержка перед началом анимации ?>
-webkit-animation-delay: <?=$val?>; <? # Chrome, Safari, Android и iOS ?>
-moz-animation-delay: <?=$val?>; <? # Firefox до версии 16.0 ?>
-o-animation-delay: <?=$val?>; <? # Opera до версии 12.10 ?>
animation-delay: <?=$val?>;