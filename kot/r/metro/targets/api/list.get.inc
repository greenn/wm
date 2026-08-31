<?
$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
	//'path' => ''
));
//$path = $_ctx['path'];

$data = mc::item_all('targets-list');

$list = array();
foreach ($data as $item) {
	$id = $item['uid'];
	$_response = kot_api::get('targets/item', array('id' => $id));
	if ($_response['error']) return $_response;
	$list []= $_response['data']['item'];
}
//dx($list);

return kot_api::response(array(
	'list' => $list,
));