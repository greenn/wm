<?
kot_api::$dbgMe = false;

$error = false;
$sql_error = false;
$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
	'id' => '',
));
$id = $_ctx['id'];

//$data = api_kot('targets/item', array('id' => $id));
$item = kot_api::get_data_prop('item-data', 'targets/item', array('id' => $id));
unset($item['aprooved']);

//dx($item);

$data = $item;
unset($data['uid']);
unset($data['date']);

$date = time();
$data['date'] = $Self::date_value($date);
//$data['title'] = $item['title'].' (копия от '.date('d/m/Y H:i:s', $date).')';
$data['title'] = $item['title'].' (копия от '.$Self::date_value_format($date, 'copy').')';
//d('new-item-data', $data);

$response = api_kot('post', 'targets/create', array('fields' => $data));
return $response;