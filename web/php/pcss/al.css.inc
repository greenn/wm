<?
    $t = $r = $b = $l = 0;
    if (isset($arg[1])) {
        if (is_array($arg[1])) {
            list($t, $r, $b, $l) = $arg[1];
        } else {
            $t = $r = $b = $l = $arg[1];
        }
    }
?>position: absolute; top: <?=$t?>; right: <?=$r?>; bottom: <?=$b?>; left: <?=$l?>;