<?
kot_api::$dbgMe = false;

$error = false;
$sql_error = false;

$Self = _kot::self();
$apiGet = $Self::cfg_('api', 'item');
$apiCreate = $Self::cfg_('api', 'create');
$apiCreate = array('post', $apiCreate);

$_ctx = $Self::tempCtx(array(
	'id' => '',
));
$id = $_ctx['id'];



//$data = api_kot('targets/item', array('id' => $id));
$item = kot_api::get_data_prop('item-data', $apiGet, array('id' => $id));
//dx($item);

$data = $item;
unset($data['aprooved']);
unset($data['uid']);
unset($data['date']);
unset($data['sent']);

$date = time();
$data['date'] = kot('app', 'date_value_format', $date, 'db');
//$data['title'] = $item['title'].' (копия от '.date('d/m/Y H:i:s', $date).')';


$data['title'] = $item['title'].' (копия от '.kot('app', 'date_value_format', $date, 'copy').')';
//dx('new-item-data', $data, $item);

//$response = api_kot('post', $apiCreate, array('fields' => $data));
$response = api_kot($apiCreate, array('fields' => $data));
//dx($response);

return $response;