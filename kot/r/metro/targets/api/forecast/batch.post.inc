<?
$error = false;
$sql_error = false;
$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
	'id-list' => array(),
));
$id_list = $_ctx['id-list'];

$res = array();
if ($id_list) foreach ($id_list as $id) {
	//$forecast = kot_api::post_data_prop('forecast', 'targets/forecast', array('id' => $id));
	$data = kot_api::post_data('targets/forecast', array('id' => $id));
	$res[$id] = $data;
}

//dx($res);

return kot_api::response(array(
	'list' => $res
));