<?
$error = false;
$response = array();

$Self = _kot::self();
$tbName = $Self::cfg_('api', 'tb');
$apiGet = $Self::cfg_('api', 'item');

$_ctx = $Self::tempCtx(array(
	'id' => '',
	//'dbg' => false,
));
$id = $_ctx['id'];
$dbg = gt_on('dbg');

if ($id) {
	$data = mc::item_get1_all($tbName, array('uid' => $id));
	$response['sql_last'] = mc::last_sql();
	//if ($dbg) d($id, $data);
	if ($data) {
		//targets
		//kot/r/targets/api/item.get.inc:19-32

		$response['item'] = $Self::prepare_item_data($data);
		$response['item-data'] = $data;

		//if ($dbg) d($targets, $response['item']);

	} else {
		$error = mc::error();
		if (!$error) $error = "Нет такого элемента";
	}


} else { //#Q7
	$response['error'] = 'Ошибка API';
	$response['message'] = 'Не передали данные: id';
}


$response['error'] = $error;
return kot_api::response($response);