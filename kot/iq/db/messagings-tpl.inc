<?
$struct = array(
	'uid' => array('5'), //ID
	'title' => array('str'), //Наименование шаблона
	'date' => array('datetime'), //Обновлено
	'aprooved' => array('8'), //hash юзера //Статус шаблона
	'bulk-type' => array('str'),
	'bulk-aim' => array('512'), //Цель рассылки
	'bulk-title' => array('str'), //Название рассылки
	'channel' => array('str'), //coma-list //Канал информирования
	'targets' => array('str'), //coma-list
);

//$struct = array('sd', 'multi-value', $struct);


$data = array();
$data []= array(
	'uid' => '20000',
	'title' => 'тест',
	'date' => Date("Y-m-d H:i:s", strtotime("-1 hours -23 minutes -10 seconds")),
	'bulk-type' => 'Обращения пассажира',
	'bulk-aim' => 'тест',
	'bulk-title' => 'Рассылка 1',
	'channel' => 'Уведомление в ЛК',
	'targets' => '10000',
);

$data []= array(
	'uid' => '20020',
	'title' => 'тест 2',
	'date' => Date("Y-m-d H:i:s", strtotime("-2 hours -12 minutes -17 seconds")),
	'bulk-type' => 'Обращения пассажира',
	'bulk-aim' => 'тест',
	'bulk-title' => 'Рассылка 2',
	'channel' => 'Уведомление в ЛК, E-mail',
	'targets' => '10020',
);



return array(
	'struct' => $struct,
	'data' => $data,
	'data-opt' => array(
		'add_verify_prop' => 'uid'
	),
);