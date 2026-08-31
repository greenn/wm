<?
$t = (isset($arg[1]) && is_string($arg[1])) ? $arg[1] : '333ms';
$e = (isset($arg[2]) && is_string($arg[2])) ? $arg[2] : 'ease-in-out';
$d = (isset($arg[3]) && is_string($arg[3])) ? $arg[3] : false;

$c = "color $t";
if ($e) $c .= " $e";
if ($d) $c .= " $d";

print pcss('transition', $c);