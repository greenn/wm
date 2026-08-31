<?
/*
	api/rw/tool-admin/sd/item
	api/rw/tool-admin/sd/item?sd=user-type&id=1
*/
$Api = _rt::name('api');
$Self = _rw::name('tool-admin');
$_ctx = $Self::tempCtx(array(
	'sd' => false,
	'id' => false,
));

$sdName = $_ctx['sd'];
$id = $_ctx['id'];

$res = _sd($sdName)->remove($id);

return array(
	'ok' => $res,
	'id' => $id,

	'postData' => $Api::$requestData,
	'sql' => mc::last_sql()
);

//return array('ok-delete' => $Api::$requestMethod, 'ctx' => $_ctx, 'data' => $Api::$requestData);