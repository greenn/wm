<?
kot_api::$dbgMe = false;

$error = false;
$sql_error = false;
$Self = _kot::self();


$ntTarget = 'targets-list';
$ntTpl = 'targets-tpl';


$_ctx = $Self::tempCtx(array(
	'id' => '',
	'fields' => '',
	//'full_field_access' => false,
));

//dx($_ctx);

$id = $_ctx['id'];
$post = $_ctx['fields'];

//step: собираеим данные для обновления
$except_fields = array('uid', 'date');
$update = mc::item_pickFields($ntTarget, $post, $except_fields);
//dx($update, $post);

//step: расправляемся с targets данными
$targetsList = prop($update, 'targets', array());
//d($targetsList);



$targets = array();
$trgs = array();//dbg

//#T6
//dx($targetsList, $post);
$targets = array();
$targetsData = array(); //данные обновления
foreach ($targetsList as $index => $target) {
	$target_id = prop($target, 'id');
	if (isset($target['station']) && is_array($target['station'])) {
		$target['station'] = join(',', $target['station']);
	}

	if (isset($target['list']) && !is_array($target['list'])) {
		$target['list'] = array($target['list']);
	}

	if ($target_id && ($target_id !== '0')) {
		//case: update
		$response = kot_api::put('targets/target', array('target' => $target, 'id' => $target_id));
		$targetsData []= $response['data']['update'];
		//d('update', $targetsData);
	} else {
		//case: create
		$response = kot_api::post('targets/target', array('target' => $target));
		$targetsData []= $response['data']['fields'];
		//d('create', $targetsData);
		$target_id = $response['data']['target-id'];
	}

	if ($response['error']) return $response;

	//$targetsList []= kot_api::get_data_prop('item', 'targets/target', array('id' => $id));

	$trgs []= $response; //dbg
	//$responseData = $response['data'];
	$targets []= $target_id;
}
//dx($targetsList);

$update['targets'] = join(',', $targets);

//step: определяем дату обновления
$update['date'] = $Self::date_value();


//step: обновляем данные
$success = mc::item_update('targets-list', $update, array('uid' => $id));
$update['targets'] = $targetsData;

$sql_error = mc::error();
$sql_last = mc::last_sql(); //dbg

$item = kot_api::get_data_prop('item', 'targets/item', array('id' => $id));

//dx($item, $update);

//dx($fields, mc::last_sql(), mc::error(), $res1, $res2);
return kot_api::response_res($success, array(
//return array(
	'item' => $item,
	'id' => $id,
	'update' => $update,

	'dbg' => array(
		'sql_error' => $sql_error,
		'sql_last' => $sql_last,
		'id' => $id,
		'post' => $post,
		'update' => $update,
		'ajax' => $ctx = $Self::temp_last(),
	)
//);
));