<?
$struct = array('sd', 'multi-value', array(
	'type = rel:user-type' => false,
	'login' => array('string', 'unique'),
	'pass = sd:user-pass' => 'CHAR(32)',
	//'sd:user-pass' => false,
));

$data = array(
	array(1, 'pew', md5('kkk')),
	array(4, 'olga', md5('ooo')),
	array(3, 'boss', md5('ooo')),
	array(6, 'sport', md5('ttt')),
	array(6, 'sport2', md5('ttt')),
	array(5, 'master', md5('rrr')),
	array(8, 'guest', md5('000')),
);
$data = array();

return array(
	'struct' => $struct,
	'data' => $data,
);