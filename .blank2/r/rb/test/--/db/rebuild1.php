<?
include_once $_SERVER['DOCUMENT_ROOT'].'/metro-targets/iq.inc';
_needphp('pro/idb.class');
$dbStruct = pro::db_struct();
$tbName = 'targets-tpl';
$tbData = $dbStruct[$tbName];
//dx($tbData);


d(mc::table_clear($tbName), mc::item_all($tbName));

//dx();


//$isExist = mc::table_exist($tbName); dx($isExist);
$isExist = idb::mc('table_exist', $tbName);
//dx($isExist, mc::item_all($tbName));

idb::init_item_data($tbName, $tbData['data'], prop($tbData, 'data-opt'));




dx(mc::item_all($tbName));

$isExist = static::mc('table_exist', $tbName);