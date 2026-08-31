<?


_needphp('fq/str/str2val', 'str/endsWith');

$ntInfo = 'db-info';
$ntData = 'targets-list';
$wrInfo = array('table' => $ntData);


$error = false;
$sql_error = false;
$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
	'fields' => '',
));

$fields = $_ctx['fields'];

//step: расправляемся с targets данными
$targetsData = prop($fields, 'targets', array());
//d($fields, $targetsData);

$targets = array();
$targetsList = array();
$trgs = array();//dbg
foreach ($targetsData as $index => $target) {
	//dx($target);
	if (isset($target['station'])) $target['station'] = join(',', $target['station']);

	if (isset($target['list']) && !is_array($target['list'])) {
		$target['list'] = array($target['list']);
	}

	//d($target);
	$response = kot_api::post('targets/target', array('target' => $target));
	//d($response);
	//dbg
		//kot_api::__response_push('trgs', $response);
		$trgs []= $response;

	if ($response['error']) return $response; //kot_api::response_trans_error()
	//$responseData = $response['data'];
	$targetsList []= $response['data']['fields'];
	$targets []= $response['data']['target-id'];
}

//dx($trgs, $targets);

$fields['targets'] = join(',', $targets);

//step: определяем дату обновления
if (!isset($fields['date'])) {
	$fields['date'] = $Self::date_value();
}


//step: получаем uid
$lastId = mc::item_get1_prop('last_id', $ntInfo, $wrInfo);
$newId = $lastId + 20;
$fields['uid'] = $newId;

//step: добавляем target-rec


$fields = mc::item_pickFields($ntData, $fields);
$res1 = mc::item_add($ntData, $fields);

$sql_error = mc::error();
$sql_last = mc::last_sql(); //dbg

$res2 = mc::item_update($ntInfo, array('last_id' => $newId), $wrInfo);
$success = $res1 !== false && $res2 === true;

$item = $fields;
$item['targets'] = $targetsList;
//dx($fields);
return kot_api::response_res($success, array(
	'new-item' => $Self::prepare_item_data($item),
	'new-item-data' => $fields,
	'new-id' => $newId,

	'error' => $error,

	'ajax' => $_ctx,
	'sql_error' => $sql_error,
	'sql_last' => @$sql_last,

	'dbg' => 'res1;res2;trgs',
	'trgs' => $trgs,
	'res1' => $res1,
	'res2' => $res2,
));