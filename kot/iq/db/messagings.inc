<?
$struct = array(
	'uid' => array('5'), //ID
	'title' => array('str'), //Наименование шаблона
	'date' => array('datetime'), //Обновлено
	'aprooved' => array('8'), //hash юзера
	//'status' => array('int+1'), //{0-9} Статус шаблона: 1 - Не согласовано | 2 - Черновик | 3 - Завершена |
	'req' => array('bool'), //Обязательность информирования
	'bulk-type' => array('str'), //Тип оповещения: Опросы | Прочее | Спецпредложения | Обращения пассажира | Изменение баланса носителя |
	'bulk-aim' => array('512'), //Цель рассылки
	'bulk-title' => array('str'), //Название рассылки

	'channel' => array('str'), //coma-list //Канал информирования
	'sent' => array('datetime'), //Отправлено
	'tpl' => array('str'), //Шаблон рассылки
);

//$struct = array('sd', 'multi-value', $struct);


$data = array();
$data []= array(
	'uid' => '30000',
	'title' => 'Рассылка 1',
	//'status' => '2',
	'date' => Date("Y-m-d H:i:s", strtotime("-1 hours -23 minutes -10 seconds")),
	'bulk-type' => 'Обращения пассажира',
	'bulk-aim' => 'тест',
	'channel' => 'Уведомление в ЛК',
	'tpl' => '20000',
	'req' => true,
);

$data []= array(
	'uid' => '30020',
	'title' => 'Рассылка 2',
	//'status' => '2', //Завершена
	'date' => Date("Y-m-d H:i:s", strtotime("-2 hours -12 minutes -17 seconds")),
	'sent' => Date("Y-m-d H:i:s", strtotime("-10 minutes")),
	'bulk-type' => 'Обращения пассажира',
	'bulk-aim' => 'тест',

	'channel' => 'Уведомление в ЛК, E-mail',
	'tpl' => '20020',
	'req' => false,
);



return array(
	'struct' => $struct,
	'data' => $data,
	'data-opt' => array(
		'add_verify_prop' => 'uid'
	),
);