<?
include_once $_SERVER['DOCUMENT_ROOT'].'/metro-targets/iq.inc';
d($METRO->cfg);

_needphp('pro/idb.class');

$dbStruct = pro::db_struct();
$tbName = 'messagings-tpl';
$tbData = $dbStruct[$tbName];

if (gt_on('rebuild')) {
	//idb::mc('table_delete', $tbName); //~ mc::table_delete($tbName);
	mc::table_delete($tbName);

	$isCreated = idb::init_item_struct($tbName, $tbData['struct']);
}

$isExist = idb::mc('table_exist', $tbName);

d(@$isCreated, $isExist);

//d($dbStruct[$tbName]);
//d($isExist, mc::item_all($tbName));

$tbDataSet = $tbData['data'];
$tbDataOpt = $tbData['data-opt'];
idb::init_item_data($tbName, $tbDataSet, $tbDataOpt);

d(mc::last_sql(), mc::error());

d($tbDataSet, $tbDataOpt, mc::item_all($tbName));

exit;