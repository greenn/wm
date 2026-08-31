<?
$ntTarget = 'targets-tpl';

$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
	'id' => '',
));
$target_id = $_ctx['id'];

//#Q7

$data = mc::item_get1_all($ntTarget, array('id' => $target_id));
//d($target_id, $data);


return kot_api::response_res($data, array(
	'item-id' => $target_id,
	'item' => $data,

	//'dbg-res' => $data,
	'ajax' => $Self::temp_last(),
));