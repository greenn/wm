<? $val = $arg[1]; ?>
<? if (is_array($val)) $val = join(', ', $val); ?>
-webkit-transition-property: <?=$val?>;
-moz-transition-property: <?=$val?>;
<?/* -ms-transition-property: <?=$val?>; <? # IE10 (the first stable version of IE to support transition-property) does not require the -ms- prefix. ?>*/?>
-o-transition-property: <?=$val?>;
transition-property: <?=$val?>;
<? # https://css-tricks.com/almanac/properties/t/transition-property/ ?>