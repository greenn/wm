<? $val = $arg[1]; ?>
<? if (is_array($val)) $val = join(', ', $val); ?>
-webkit-transition-delay: <?=$val?>;
-moz-transition-delay: <?=$val?>;
<?/* -ms-transition-delay: <?=$val?>; <? # IE10 (the first stable version of IE to support transition-delay) does not require the -ms- prefix. ?>*/?>
-o-transition-delay: <?=$val?>;
transition-delay: <?=$val?>;
<? # https://css-tricks.com/almanac/properties/t/transition-delay/ ?>