<?
$ntItem = 'targets-list';

$error = false;
$sql_error = false;
$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
	'id' => '',
	'update' => true,
));
$id = $_ctx['id'];
$doUpdate = $_ctx['update'];


$item = kot_api::get_data_prop('item-data', 'targets/item', array('id' => $id));
//dx($item, $item['targets']);

//$coverage = kot_api::post('targets/forecast/aggregate', array('targets' => $item['targets']));
//$coverage = kot_api::post_data_prop('coverage', 'targets/forecast/aggregate', array('targets' => $item['targets']));
//dx($item['targets'], $coverage);

$coverageResponse = kot_api::post_data('targets/forecast/aggregate', array('targets' => $item['targets']));
$coverage = $coverageResponse['coverage'];
$aggregateRequest = $coverageResponse['clickhouseRequest'];
//dx($coverageResponse);


if ($doUpdate) {
	$update = array(
		'forecast' => $coverage,
		//'date' => $Self::date_value(),
	);
	$success = mc::item_update($ntItem, $update, array('uid' => $id));
	if (!$success) return kot_api::response_res($success);
}


return kot_api::response(array(
	'forecast' => $coverage,
	'clickhouse' => $aggregateRequest,
	//'date' => $Self::date_value_format($update['date']),
));