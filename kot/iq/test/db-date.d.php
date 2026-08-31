<?
include_once $_SERVER['DOCUMENT_ROOT'].'/metro-targets/iq.inc';

//$tmp = time();
//dx($tmp, strlen($tmp));


_needphp('pro/idb.class');


if (0) idb::init_cfg_item('dates', array(
	'struct' => array(
		'id' => array('auto-id', 'int-4'),
		'date' => array('date'),
		'datetime' => array('datetime'),
		'tmp' => array('tmp'),
	),
	//'data' => $data,
));

if (0) {

	$sql = "DESCRIBE `dates`;";
	dx(
		mc::query($sql),
		mc::last_sql(),
		mc::error(),
		mc::query_rd($sql),
		mc::query_r($sql),
		mc::query_rl($sql),
		42
	);

}

//INSERT INTO your_table DEFAULT VALUES


if (0) {
	//ошибка
	// You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'DEFAULT VALUES' at line 1
	$sql = "INSERT INTO `dates` DEFAULT VALUES ;";
	dx(
		mc::query($sql),
		mc::last_sql(),
		mc::error(),
		mc::query_rd($sql),
		mc::query_r($sql),
		mc::query_rl($sql),
		42
	);
}


if (0) {
	//ошибка
	//INSERT INTO your_table (column1, column2, column3) VALUES (DEFAULT, DEFAULT, DEFAULT);
	$sql = "INSERT INTO `dates` DEFAULT VALUES ;";
	dx(
		mc::query($sql),
		mc::last_sql(),
		mc::error(),
		mc::query_rd($sql),
		mc::query_r($sql),
		mc::query_rl($sql),
		42
	);
}



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
