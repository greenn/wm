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

//return array('ok-get' => $Api::$requestMethod, 'ctx' => $_ctx, 'data' => $Api::$requestData);

$id = $_ctx['id'];
$sdName = $_ctx['sd'];

$item = null;
if ($sdName) {
	$item = _sd($sdName)->get1_all(array('id' => $id));
}

return array('item' => $item);