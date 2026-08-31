<?
$struct = array(
	'uid' => array('5'),
	'title' => array('str'),
	'date' => array('datetime'),
	'aprooved' => array('8'), //hash юзера
	'targets' => array('512'), //coma-list
	'forecast' => array('str-7'),
);

//$struct = array('sd', 'multi-value', $struct);


$data = array();
$data []= array(
	'uid' => '10000',
	'title' => 'тест',
	'date' => Date("Y-m-d H:i:s", strtotime("-1 hours -23 minutes -10 seconds")),
	'targets' => '1',
);

$data []= array(
	'uid' => '10020',
	'title' => 'Новый шаблон',
	'date' => Date("Y-m-d H:i:s", strtotime("-2 hours -12 minutes -17 seconds")),
	'targets' => '2,3',
);



return array(
	'struct' => $struct,
	'data' => $data,
	'data-opt' => array(
		'add_verify_prop' => 'uid'
	),
);