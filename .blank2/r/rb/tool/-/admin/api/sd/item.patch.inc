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
	'data' => false,
));

$id = $_ctx['id'];
$sdName = $_ctx['sd'];
$data = $_ctx['data'];

$res = _sd($sdName)->update($id, $data);

return array(
	'success' => $res,
	'data' => $data,
	'id' => (int)$id,

	'postData' => $Api::$requestData,
	'sql' => mc::last_sql()
);
//return array('ok-patch' => $Api::$requestMethod, 'ctx' => $_ctx, 'data' => $Api::$requestData);
//return array('ok-put' => $Api::$requestMethod, 'ctx' => $_ctx, 'data' => $Api::$requestData);