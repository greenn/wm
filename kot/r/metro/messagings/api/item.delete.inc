<?
$Self = _kot::self();
$tbName = $Self::cfg_('api', 'tb');

$_ctx = $Self::tempCtx(array(
	'id' => ''
));
$id = $_ctx['id'];

$res = mc::item_delete($tbName, array('uid' => $id));
//dx($res, mc::last_sql());

return kot_api::response_res(!!$res);
