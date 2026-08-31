<?

$db['licenses'] = array(
	1 => array(1, 12, 'A'),
	2 => array(2, 5, 'B'),
	3 => array(3, 1, 'C'),
	4 => array(4, 6, 'D'),
	5 => array(5, 20, 'M'),

	//6 => array('Варя', 'Черноус', 'Игоревна', '-', 'asmus@mail.ru'),
);

foreach ($db['licenses'] as $key => $data) {
	$db['licenses'][$key] = array(
		'key' => $key,
		'key_client' => $data[0],
		'staz' => $data[1],
		'cat' => $data[2],
	);
}