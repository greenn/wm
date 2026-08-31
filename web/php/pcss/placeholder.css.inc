<?
    $ssr = isset($arg[1]) ? $arg[1] : '%s'; //stack of selectors
    $val = isset($arg[2]) ? $arg[2] : '%s';
    $add = isset($arg[3]) ? $arg[3] : false;
    if ($add) $sr .= ' INPUT';

    if (is_array($val)) $val = join(';'."\r\n", $val);

    if (!is_array($ssr)) $ssr = explode(',', $ssr);
?>
<? foreach ($ssr as $sr) { ?>
<?=$sr?>::-webkit-input-placeholder { <?=$val?> } <?# Chrome|Opera|Safari8 ?>
<?=$sr?>::-moz-placeholder { <?=$val?> } <?# > Firefox 19 ?>
<?=$sr?>:-ms-input-placeholder { <?=$val?> } <?# > IE 10 ?>
<?=$sr?>:-moz-placeholder { <?=$val?> } <?# < Firefox 18 ?>
<? } ?>
