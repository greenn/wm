<?
/*
	api/rw/tool-admin/sd/item
	api/rw/tool-admin/sd/item?sd=user-type&id=1
*/
$Api = _rt::name('api');
$Self = _rw::name('tool-admin');
$_ctx = $Self::tempCtx(array(
	'sd' => false,
	'data' => false,
	'id' => false,
));

$id = $_ctx['id'];
$sdName = $_ctx['sd'];
$data = $_ctx['data'];

$newId = _sd($sdName)->add($data);
$sqlCreate = mc::last_sql();
$item = _sd($sdName)->get1_all(array('id' => $newId));

return array(
	'newId' => $newId, 'item' => $item,
	'postData' => $Api::$requestData,
	'sql' => $sqlCreate
);