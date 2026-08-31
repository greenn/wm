<?
    $val = $arg[1];
    if (is_array($val)) {
        foreach ($val as &$value)
            if (preg_match('~^[\w-]+$~', $value))  //https://regex101.com/r/os0b0g/1
                $value = cbn($value);
        $val = join(', ', $val);
    } else {
        if (preg_match('~^[\w-]+$~', $val))
            $val = cbn($val);
    }
?>
-webkit-transition-timing-function: <?=$val?>;
-moz-transition-timing-function: <?=$val?>;
<?/* -ms-transition-timing-function: ease-in-out; <? # IE10 (the first stable version of IE to support transition-timing-function) does not require the -ms- prefix. ?>*/?>
-o-transition-timing-function: <?=$val?>;
transition-timing-function: <?=$val?>;
<? # https://css-tricks.com/almanac/properties/t/transition-timing-function/ ?>