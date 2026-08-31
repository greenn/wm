<?
if (0) $data = array(
	array('developer'),
	array('manager'),
	array('aministrator'),
	array('director'),
	array('editor'),
	array('sportsmain'),
	array('trainer'),
);


$data = array();

$src = array(
	1 => 'developer',
	3 => 'director',
	4 => 'administrator',
	6 => 'sportsmain',
	5 => 'trainer',
	8 => 'guest',
	11 => 'manager',
	10 => 'editor',

);

foreach ($src as $key => $type) {
	$data []= array('id' => $key, 'value' => $type);
}


return array(
	'struct' => array(
		'id' => array('auto-id', 'int-3'),
		'value' => array('25', 'unique'),
	),
	'data' => $data,
);