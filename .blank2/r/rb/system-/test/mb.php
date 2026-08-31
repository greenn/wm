<?
//tt site/rp/__/test/mb.php?self
include_once $_SERVER['DOCUMENT_ROOT'].'/site/iq.inc';
include_once WEB.'/tools/mb/mb.inc';

$w = 300;
$h = 400;

//$relName = strLess(basename(__FILE__), '.mb.php', true);
$relName = gi_key(0, 'self');
$uri = dirUrl(__FILE__, true, true)."$relName.php";

$res = mb::section($uri, array(
	'width' => $w,
	'height' => $h
));

print $res;