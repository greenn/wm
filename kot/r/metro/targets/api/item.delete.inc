<?
$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
	'id' => ''
));
$id = $_ctx['id'];

$res = mc::item_delete('targets-list', array('uid' => $id));
//dx($data, mc::last_sql());

#T6

return kot_api::response_res($res);
