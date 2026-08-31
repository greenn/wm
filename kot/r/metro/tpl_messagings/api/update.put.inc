<?
kot_api::$dbgMe = false;

$error = false;
$sql_error = false;

$Self = _kot::self();
$tbName = $Self::cfg_('api', 'tb');
$apiGet = $Self::cfg_('api', 'item');

$_ctx = $Self::tempCtx(array(
	'id' => '',
	'fields' => '',
	//'full_field_access' => false,
));

//dx($_ctx);

$id = $_ctx['id'];
$post = $_ctx['fields'];

//step: собираеим данные для обновления
$except_fields = array('uid', 'date', 'sent');
$update = mc::item_pickFields($tbName, $post, $except_fields);
//dx($update, $post);

//step: расправляемся с targets данными
//oo kot/r/targets/api/update.put.inc:30-75

//step: определяем дату обновления
$update['date'] = kot('app', 'date_value_format', time(), 'db');

//step: обновляем данные
$success = mc::item_update($tbName, $update, array('uid' => $id));
	//dbg
	$sql_error = mc::error();
	$sql_last = mc::last_sql();

$item = kot_api::get_data_prop('item', $apiGet, array('id' => $id));

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