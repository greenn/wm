<?

$db['passports'] = array(
	1 => array(1, '4004', '456123', '2000-01-21'),
	2 => array(2, '4004', '127845', '2000-04-01'),
	3 => array(3, '4004', '561337', '2000-05-07'),
	4 => array(4, '4004', '751228', '2000-04-13'),
	5 => array(5, '4004', '456811', '2000-03-22'),
);

foreach ($db['passports'] as $key => $data) {
	$db['passports'][$key] = array(
		'key' => $key,
		'key_client' => $data[0],
		'seria' => $data[1],
		'nomer' => $data[2],
		'bdate' => $data[3],
	);
}