<?/*
	добавляем таблицу user-type
	и тренируем на ней sd объект
*/
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('sd');
_needphp('pro/idb.class');

//_sd('user-type')->add('test1');
if (0 && 'test1') {
	//$res = _sd('user-type')->remove(8);
	$res = _sd('user-type')->remove_where('value', 'editor');
	dx($res, mc::error());
}

if (1 && 'test2') {
	_sd('user-type')->_add(array(
		'id' => 9,
		'value' => 'test-9',
	));

	d(mc::error());
}

if (0 && 'test3') {
	_sd('user-type')->add('aug');
	_sd('user-type')->add('aug2');
}

if (1 && 'test4') {
	$res = _sd('user-type')->get_id('op1', true);
	d($res);
}


