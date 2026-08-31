<?
$Self = _kot::self();
$tbName = $Self::cfg_('api', 'tb');

$_ctx = $Self::tempCtx(array(
	'by' => 'id'
));
$prop = $_ctx['by'];

$listData = mc::item_all($tbName);
$list = $Self::prepare_list($listData);

return kot_api::response(array(
	'list' => $list,
	'list-data' => $listData,
));