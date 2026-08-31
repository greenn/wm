<?
$error = false;
$sql_error = false;
$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
	'id' => '',
));
$id = $_ctx['id'];


$success = mc::item_update('targets-list', array('aprooved' => _u::agent_info('hash')), array('uid' => $id));
$sql_error = mc::error();
$sql_last = mc::last_sql(); //dbg

$item = kot_api::get_data_prop('item', 'targets/item', array('id' => $id));
//dx($item, $id);

return kot_api::response_res($success, array(
	'item' => $item,
	'dbg' => array(
		'sql_error' => $sql_error,
		'sql_last' => $sql_last,
	)
));