<?
$v = 1;
$_tpl = gjs_path($arg[0].".$v", true);

$argName = prop($arg, 1, 'x');
$propName = prop($arg, 1, $argName);

$snippet = gjs_replace(
    inc($_tpl, INC_RES_AS_STRING),
    array(
        'set' => $argName, //object property name
        'n' => $propName, //string property value name
    )
);

//print "\r\n".$snippet;
print $snippet;