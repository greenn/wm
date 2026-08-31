<?
$Self = _rb::self();
$_ctx = $Self::tempCtx(array(
	//'start' => strtotime('-1 hours'),
	//'until' => strtotime('+2 hours'),

	'start' => '-1 hours',
	'until' => '+2 hours',
	'success' => array(),

));

$start = $_ctx['start'];
$until = $_ctx['until'];

$success = array_replace(array(
	'msg' => 'Обновление успешно выполнено',
	'error' => 0,
	'warn' => 0,
), $_ctx['success']);

$list = array();

$list []= array(
	'Обновление' => array(
		$start,
		$until,
	),
);

//d($success, $list);

return array(
	'page-title' => 'Обновление',

	'success' => $success,

	'process' => $list,

	'2process' => array(
		array(
			'Загрузка и развёртывание файлов' => array(
				'2024-04-07 09:30:00',
				'2024-01-16 10:30:00',
			),
		),
	)

);