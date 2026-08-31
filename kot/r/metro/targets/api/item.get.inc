<?
$error = false;
$response = array();

$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
	'id' => '',
	//'dbg' => false,
));
$id = $_ctx['id'];
$dbg = gt_on('dbg');

if ($id) {
	$data = mc::item_get1_all('targets-list', array('uid' => $id));
	$response['sql_last'] = mc::last_sql();
	if ($dbg) d($id, $data);
	if ($data) {
		$targets = array();
		$targetsCfg = prop($data, 'targets', '');
		if ($targetsCfg) {
			foreach (explode(',', $targetsCfg) as $target_id) {
				$_response = kot_api::get('targets/target', array('id' => $target_id));
				if ($_response['error']) return $_response;
				//d($_response['data']['item']);
				$targets []= $_response['data']['item'];
			}
		}
		//dx($targets);


		$data['targets'] = $targets;


		$response['item'] = $Self::prepare_item_data($data);
		$response['item-data'] = $data;

		if ($dbg) d($targets, $response['item']);

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