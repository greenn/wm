<? $val = $arg[1]; ?>
<?
    if (!is_callable('af_notEmpty')) {
        function af_notEmpty($var) { return !empty($var); }
    }
    if (is_array($val)) {
        $val = join(', ', array_filter($val, 'af_notEmpty'));
    }
?>
-webkit-transition: <?=$val?>;
-moz-transition: <?=$val?>;
-ms-transition: <?=$val?>;
-o-transition: <?=$val?>;
transition: <?=$val?>;
<?/*
    https://www.quirksmode.org/css/transitions/properties.html#t031

    https://developer.mozilla.org/ru/docs/Web/CSS/transition
    имя свойства | длительность | временная функция | задержка
    opacity 1s ease 1s
    имя свойства | длительность | задержка
    opacity 1s 1s
*/?>