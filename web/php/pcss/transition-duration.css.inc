<? $val = $arg[1]; ?>
<? if (is_array($val)) $val = join(', ', $val); ?>
-webkit-transition-duration: <?=$val?>;
-moz-transition-duration: <?=$val?>;
<?/* -ms-transition-duration: <?=$val?>; <? # IE10 (the first stable version of IE to support transition-duration) does not require the -ms- prefix. ?>*/?>
-o-transition-duration: <?=$val?>;
transition-duration: <?=$val?>;
<? # https://css-tricks.com/almanac/properties/t/transition-duration/ ?>