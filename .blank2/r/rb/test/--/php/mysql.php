<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

_needphp('mysql');

$db = _mysql::connection(array('zap', 'zap00'));
$db2 = _mysql::connection(array('root', ''));


$response = $db->instance->query('SHOW DATABASES');
//$rows = $response->fetch_all();
$rows = _mysql::fetch_all($response);
//dx($rows);
$db->use_db('web-test');
exit;
//$response = $db2->instance->query('SHOW DATABASES');
//$rows2 = $response->fetch_all();


dx($rows, $rows2);


$list = array();
//$rows = $db->get_all('news', array('state' => 'on'), '`NID` DESC');
$total = $db->count('news');
$rows = $db->get_all('news', array('state' => 'on'), '`NID` DESC');
$qy = count($rows);

dx($qy, $rows);