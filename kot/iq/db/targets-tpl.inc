<?
$struct_v2 = array(
	'id' => array('auto-id', 'int-4'),
	'name' => array('str-128'),
	'value' => array('str-256'),
	'value-fix' => array('bool'),
	//'value2' => array('str-256'),
	//'value2-fix' => array('bool'),
	///'status' => array('str-64'),
	///'status-fix' => array('bool'),
	'interval' => array('str-64'),
	//'interval2' => array('str-64'),
	'qy' => array('int+'),
	'qy-fix' => array('bool'),
	'numFrom' => array('int+'),
	'numTo' => array('int+'),
	'flag' => array('bool'),
	'list' => array('str-1024'),
);


$struct_v1 = array(
	'id' => array('auto-id', 'int-4'),
	'name' => array('str-128'),
	'interval' => array('str-64'),
	//'interval-fix' => array('bool'),
	///'from' => array('time'),
	//'from-fix' => array('bool'),
	///'to' => array('time'),
	///'to_preset' => array('str-64'),
	//'to-fix' => array('bool'),
	# passenger
	# passes
	# passes
	# passes
	# passes
	'passes_min' => array('int+'),
	'passes_min-fix' => array('bool'),
	'station' => array('str-256'),
	//'station-fix' => array('bool'),
	//'mcd' => array('str-256'),
	//'mcd-fix' => array('bool'),
	//'ngpt' => array('str-256'),
	//'ngpt-fix' => array('bool'),
);


//$struct = array('sd', 'multi-value', $struct);

$data = array();

$data[1] = array(//1
	'name' => 'passes/station-freq',
	'list' => '19:5,20:6',
	//'station-fix' => 0,
	//'passes_min' => '20',
	//'passes_min-fix' => 0,
	//'from' => (new DateTime("2023-08-10 12:00"))->format('Y-m-d H:i:s'),
	//'to' => (new DateTime("2023-08-16 12:00"))->format('Y-m-d H:i:s'),
	'interval' => 'last-7d',
	//'interval-fix' => 1,
);

$data[2] = array(//2
	'name' => 'passes/passes-qy',
	'qy' => '5',
	'qy-fix' => 0,
	'interval' => 'last-7d',
	//'interval-fix' => 1,
	//'from' => (new DateTime("2023-07-01 04:35"))->format('Y-m-d H:i:s'),
	//'to' => (new DateTime("2023-08-01 01:50"))->format('Y-m-d H:i:s'),
);

$data[3] = array(//3
	'name' => 'passes/station-freq',
	//'qy' => '3',
	//'qy-fix' => 1,
	'interval' => 'last-7d',
	'list' => '19:5,20:6',
	//'interval-fix' => 1,
	//'from' => (new DateTime("2023-07-01 04:35"))->format('Y-m-d H:i:s'),
	//'to' => (new DateTime("2023-08-01 01:50"))->format('Y-m-d H:i:s'),
);


return array(
	'struct' => $struct_v2,
	'data' => $data,
	/*'data-opt' => array(
		'add_verify_prop' => 'id'
	)*/

);