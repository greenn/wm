<?

$db['clients'] = array(
	1 => array('Иван', 'Иванов', 'Иванович', '+7(555) 555-55-55', 'user-1@mail.ru'),
	2 => array('Борис', 'Борисов', 'Борисович', '+7(555) 444-55-66', 'user-2@mail.ru'),
	3 => array('Сергей', 'Сергеев', 'Сергеевич', '+7(555) 555-55-77', 'user-3@mail.ru'),
	4 => array('Джон', 'Уик', 'Иванович', '+7(555) 555-55-88', 'user-4@mail.ru'),
	5 => array('Нео', 'Вачовски', 'Иванович', '+7(555) 555-55-99', 'user-5@mail.ru'),
	//6 => array('Варя', 'Черноус', 'Игоревна', '-', 'asmus@mail.ru'),
);

foreach ($db['clients'] as $key => $data) {
	$db['clients'][$key] = array(
		'key' => $key,
		'name' => $data[0],
		'surname' => $data[1],
		'secondName' => $data[2],
		'phone' => $data[3],
		'mail' => $data[4],
	);
}