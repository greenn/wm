<?

$Self = _kot::self();
$tbName = $Self::cfg_('api', 'tb');
$apiGet = $Self::cfg_('api', 'item');


$_ctx = $Self::tempCtx(array(
	'id' => '',
));
$id = $_ctx['id'];


$success = mc::item_update($tbName, array('aprooved' => ''), array('uid' => $id));
$sql_error = mc::error();
$sql_last = mc::last_sql(); //dbg

$item = kot_api::get_data_prop('item', $apiGet, array('id' => $id));

return kot_api::response_res($success, array(
	'item' => $item,
	'dbg' => array(
		'sql_error' => $sql_error,
		'sql_last' => $sql_last,
	)
));