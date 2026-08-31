<?
include_once $_SERVER['DOCUMENT_ROOT'].'/metro-targets/iq.inc';

_needphp('pro/idb.class');

/*
	oo-dev
		align_type_cfg / php/mysql/mysql_table.class.php:113
*/

if (!true && 'sim') {
	foreach(array(
		'int',
		'int-1',
		'int+2',
		'int+',
	) as $value) {
		$type = 'int';
		//$type = 'int+';
		$pattern = sprintf(mysql_table::$_type_pattern, preg_quote($type));
		$res = preg_match($pattern, $value, $match);
		d($res, $pattern, $match);
	}
}


if (1) {
	$tbName = 'test-1';

	$tbData = array(
		'struct' => array(
			//'id' => array('auto-id', 'int-4'),
			'num1' => array('int+'),
			'num2' => array('int+1'),
		),
		//'data' => $data,
	);

	if (1 && 'drop') {
		mc::table_delete($tbName);
	}

	idb::init_cfg_item($tbName, $tbData);

	d(mc::last_sql(), mc::error());
	d(mc::item_get_fields($tbName));
}


if(0) idb::init_form_output(true, array(
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
