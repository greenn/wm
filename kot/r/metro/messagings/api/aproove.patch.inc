<?
$Self = _kot::self();
$tbName = $Self::cfg_('api', 'tb');
$apiGet = $Self::cfg_('api', 'item');

$_ctx = $Self::tempCtx(array(
	'id' => '',
));
$id = $_ctx['id'];


$success = mc::item_update($tbName,
	array('aprooved' => _u::agent_info('hash')),
	array('uid' => $id)
);
$sql_error = mc::error(); //dbg
$sql_last = mc::last_sql(); //dbg

$item = kot_api::get_data_prop('item', $apiGet, array('id' => $id));
//dx($item, $id);

return kot_api::response_res($success, array(

	'item' => $item,

	'dbg' => array(
		'sql_error' => $sql_error,
		'sql_last' => $sql_last,
	)
));