<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('sd');
_needphp('pro/idb.class');


_sd::info_init();

$db = pro::db_struct();
$_cfg = $db['user-type'];
if (0 && 'test-1') {
	$_struct = $_cfg['struct'];
	$res = idb::init_item_struct('user-type', $_struct);
	dx($res, $_struct, mc::error());
}

if (1 && 'test-2') {
	d($_cfg);

	if (0 && 'test2.1') {
		$cfgValue = mc::table_align_item_cfg($_cfg['struct']['value']);
		dx($cfgValue, mysql_table::combine_cfg($cfgValue, mysql_table::$item_props));
	}

	idb::init_cfg_item('user-type', $_cfg);
	dx(true);
}

