<?
$t = (isset($arg[1]) && is_string($arg[1])) ? $arg[1] : '333ms';
$e = (isset($arg[2]) && is_string($arg[2])) ? $arg[2] : 'ease-in-out';
$d = (isset($arg[3]) && is_string($arg[3])) ? $arg[3] : false;

$c = "opacity $t";
if ($e) $c .= " $e";
if ($d) $c .= " $d";



//$c = "$t opacity $e";
//if ($d) $c = "$d $c";

//if (isset($arg[1]) && is_numeric($arg[1])) {}

print pcss('transition', $c);