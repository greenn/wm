<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$ao = array(1,33);
$ao['e'] = 111;
$ao []= 44;
dx($ao);
/*
	'0' => 1
	'1' => 33
	'e' => 111
	'2' => 44
*/