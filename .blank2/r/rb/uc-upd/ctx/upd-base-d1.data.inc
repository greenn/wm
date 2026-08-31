<?
$Self = _rb::self();
$_ctx = $Self::tempCtx(array(
	//'start' => strtotime('-1 hours'),
	//'until' => strtotime('+2 hours'),

		'start' => '-1 hours',
		'until' => '+2 hours',

	'until2' => true,
	'until3' => false,
));

$start = $_ctx['start'];
$until = $_ctx['until'];
$until2 = $_ctx['until2'];
$until3 = $_ctx['until3'];

if ($until2 === true) {
	$until2Date = new DateTime($until);
	$until2Date->modify('+30 minutes');
	$until2 = $until2Date->format('Y-m-d H:i:s');
}

$list = array();

$list []= array(
	'Обновление' => array(
		$start,
		$until,
	),
);

if ($until2) {
	$list []= array(
		array(
			$until,
			$until2
		),
		array(
			'Слияние изменений и обновлений' => 30,
			'Проверка целостности данных' => 15,
			'Автоматическое тестирование и проверка' => 15,
		)
	);
}

if ($until3) {
	$list []= array(
		array(
			//$until2 ? $until2 : $until,
			$until2,
			$until3
		),
		array(
			'Инициализация ядра системы' => 55,
			'Инициализация базы данных и подключение к серверу' => 5,
			'Подключение и настройка API' => 10,
			'Компиляция скриптов и стилей' => 35,
			'Загрузка модулей пользовательского интерфейса' => 20,
			'Аутентификация сервисов и подсистем' => 8,
			'Построение маршрутов' => 5,
			'Оптимизация кэширования' => 5,
			'Выгрузка и синхронизация оперативных данных' => 12,
			//'Формирование SEO данных: метатеги, sitemap, robots.txt, jsonld' => 11,
			'Запуск сервисов и планировщика' => 10,
			'Финальная проверка интеграций' => 20,
		)
	);
}

//dx($list);

return array(
	'page-title' => 'Обновление',

	'success' => array(
		'msg' => 'Обновление успешно выполнено',
		'error' => 0,
		'warn' => 27,
	),

	'process' => $list

);