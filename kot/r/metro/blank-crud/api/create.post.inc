<?
_needphp('fq/str/str2val', 'str/endsWith');

$Self = _kot::self();
$ntInfo = $Self::cfg_('api', 'tbInfo');
$tbName = $Self::cfg_('api', 'tb'); //ak $ntList
$apiGet = $Self::cfg_('api', 'item');
$wrInfo = array('table' => $tbName);

$_ctx = $Self::tempCtx(array(
	'fields' => '',
));

$fields = $_ctx['fields'];
//dx($fields, rt_api::$requestMethod);


//step: расправляемся с targets данными
//oo kot/r/targets/api/create.post.inc:21-47

//step: определяем дату обновления
if (!isset($fields['date'])) {
	$fields['date'] = kot('app', 'date_value_format', time(), 'db');
}

//step: получаем uid
$lastId = mc::item_get1_prop('last_id', $ntInfo, $wrInfo);
$newId = $lastId + 20;
$fields['uid'] = $newId;



$pikFields = mc::item_pickFields($tbName, $fields);
//dx($fields, $pikFields);
$res1 = mc::item_add($tbName, $pikFields);
$sql_error = mc::error();
$sql_last = mc::last_sql(); //dbg

//dx($res1, $fields, $sql_error, $sql_last, kot_api::get_data_prop('item', $apiGet, array('id' => $newId)));

//$prevTbInfo = mc::item_all($ntInfo);
$res2 = mc::item_update($ntInfo, array('last_id' => $newId), $wrInfo);
//$curTbInfo = mc::item_all($ntInfo);
//dx($res2, $prevTbInfo, $curTbInfo);

$success = $res1 !== false && $res2 === true;

$item = kot_api::get_data_prop('item', $apiGet, array('id' => $newId));

//dx($fields);
return kot_api::response_res($success, array(
	'new-item' => $item,
	'new-item-data' => $pikFields,
	'new-id' => $newId,


	'sql_error' => $sql_error,
	'sql_last' => @$sql_last,

	'dbg' => 'res1;res2;trgs;post',
	'post' => $_ctx,
	'res1' => $res1,
	'res2' => $res2,
));