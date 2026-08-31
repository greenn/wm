<?#4.3.2

$chunks = explode('/', $_SERVER['REQUEST_URI']);

foreach (array($chunks[2], $chunks[3]) as $chunk) {
	switch ($chunk) {
		case 'kot': case 'kmod': case 'pik': case 'admin': {
			include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
		} break;
	}
}

include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('strLess');
_needphp('fq/str/str2val');

//_needphp('x.class/_x');

$response = false;

//$r_list = array('rp', 'rt', 'rb', 'rw');
//$r_list = array('site', 'rt', 'rb', 'rw',  'kot', 'crm', 'acc');
$r_list = array('rb', 'kot', 'kmod', 'pik', 'admin', 'site', 'acc', 'ripr');
$reData_list = array('post', 'put', 'patch', 'delete');
//$emuMethod_list = array_merge(array('get'), $reData_list);
$emuMethod_list = array('get', 'post', 'put', 'patch', 'delete');



$Api = _rt::self();
$Api::$dbg = true && isLocalhost;
$Api::$dbg = false;

//step: читаем входящие данные
$requestUri = strLess('/'.pageUri, $Api::uri('/'));
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestData = $_REQUEST;
if (in_array(strtolower($requestMethod), $reData_list)) {
	parse_str(file_get_contents('php://input'), $requestData);
}

//если приходят JSON-данные
$requestHeaders = getallheaders();
$isDataRebuiled = false;
if (prop($requestHeaders, 'Content-Type') == "application/json") {
	$requestData = json_decode(file_get_contents('php://input'), true);
	$isDataRebuiled = true;
}


//проверяем возможность emu-rest-запроса через get-запрос
$firstChunk = strtolower(strtok($requestUri, '/'));
if (in_array($firstChunk, $emuMethod_list)) {
	$requestMethod = $firstChunk;
	$requestUri = substr($requestUri, strlen($firstChunk) + 1);
	$r = strtok($requestUri, '/');
} else {
	$r = $firstChunk;
}

if (in_array($r, $r_list)) {
	$requestUri = substr($requestUri, strlen($r) + 1);
	switch ($r) {
		case 'rw': {
			include_once __DIR__.'/rw.list.inc';
		} break;
		case 'kot': case 'kmod': case 'pik': case 'admin': {
			include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
		} break;
	}
}

//dx($requestUri, strtok($requestUri, '/'), $requestUri, strtok('/'), $requestUri);


$response = $Api::response($requestUri, $requestData, $requestMethod, $r);

//parse_str(file_get_contents('php://input'), $_INPUT);
//$response['api-request'] = array('requestData' => $requestData, 'requestMethod' => $requestMethod, '$_POST' => $_POST, '$_GET' => $_GET, '$_INPUT' => $_INPUT);

if ($Api::$dbg) {
	$response['requestData'] = $Api::$requestData;
	$response['requestMethod'] = $Api::$requestMethod;
	$response['requestUri'] = $Api::$requestUri;
	$response['application/json'] = $ContentType = prop($requestHeaders, 'Content-Type');
	$response['Content-Type'] = $ContentType;
	$response['isDataRebuiled'] = $isDataRebuiled;
}

$Api::output($response);


/*
	_api::addRoute('log', array('rw', 'tool-log'));
*/