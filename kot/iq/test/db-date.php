<?
include_once $_SERVER['DOCUMENT_ROOT'].'/metro-targets/iq.inc';

_needphp('pro/idb.class');

if (gt_has('build')) {
	idb::init_form_output(true, array(
		'dates' => array(
			'struct' => array(
				'id' => array('auto-id', 'int-4'),
				'date' => array('date'),
				'datetime' => array('datetime'),
				'tmp' => array('tmp'),
			),
			//'data' => $data,
		)
	));
}


if (1) {
	$tmp = time();
	/*
		INSERT INTO your_table (column1, column2, column3) VALUES (DEFAULT, DEFAULT, DEFAULT);
		INSERT INTO your_table (id, tmp, date_only, timestamp_col) VALUES (1, '2022-01-01 15:30:00', '2022-01-01', CURRENT_TIMESTAMP);
		$sql = "INSERT INTO `dates` DEFAULT VALUES ;";
	*/

	$res = mc::item_add('dates', array(
		'datetime' => date('Y-m-d H:i:s', $tmp),
		'date' => date('Y-m-d', $tmp),
		//такое же значение вставить по умолчанию
		//2) 'tmp' => array('const' => 'CURRENT_TIMESTAMP'),

		//3 error)  'tmp' => $tmp, //ошибка, надо указывать как date('Y-m-d H:i:s', $tmp),
	));

	dx(
		$res,
		mc::last_sql(),
		mc::error(),
		mc::get_all('dates'),

		42
	);
}


