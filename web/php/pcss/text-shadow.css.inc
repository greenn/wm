<?
    $val = isset($arg[1]) ? $arg[1] : '%s';
    if (is_array($val)) $val = join(", \n\t", $val).';';

    //https://css-tricks.com/almanac/properties/t/text-shadow/
    //https://stackoverflow.com/questions/2075805/cross-browser-text-shadow
?>

text-shadow: <?=$val?>;