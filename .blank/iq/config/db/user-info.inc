<?
$dbCtx = isset($_ctx) ? $_ctx : array();

$struct = array(
	'uid' => $dbCtx['uid-struct'],
	'login' => array('str'),
	'name' => array('str'),
	'surname' => array('str'),
	'patronymic' => array('str'),
	'email' => array('str'),
	'mobile' => array('str'),
);

return array(
	'struct' => $struct,
);