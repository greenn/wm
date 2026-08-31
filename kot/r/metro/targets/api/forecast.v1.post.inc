<?
$ntItem = 'targets-list';

$error = false;
$sql_error = false;
$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
	'id' => '',
));
$id = $_ctx['id'];

$data = mc::item_get1(array('forecast', 'date', 'targets'), $ntItem, array('uid' => $id));
//if ($_response['error']) return $_response;
if (!$data) return kot_api::response_res($data);

if ($data['targets']) {
	$newVal = $Self::fake_forecast($data['forecast'], $data['date']);
} else {
	$newVal = 0;
}


$update = array(
	'forecast' => $newVal,
	'date' => $Self::date_value(),
);
$success = mc::item_update($ntItem, $update, array('uid' => $id));
if (!$success) return kot_api::response_res($success);

return kot_api::response(array(
	'forecast' => $newVal,
	'date' => $Self::date_value_format($update['date']),
));