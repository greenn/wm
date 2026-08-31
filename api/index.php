<?#4.5.3

$chunks = explode('/', $_SERVER['REQUEST_URI']);

foreach (array($chunks[2], $chunks[3]) as $chunk) {
	switch ($chunk) {
		/*case 'kot': case 'kmod': case 'pik': {
			include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
		} break;*/

		/*case 'admin': {
			include_once $_SERVER['DOCUMENT_ROOT'].'/ap/iq.inc';
		} break;*/
	}
}

include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('strLess');
_needphp('fq/str/str2val');

//_needphp('x.class/_x');

$response = false;

//$r_list = array('rp', 'rt', 'rb', 'rw');
//$r_list = array('site', 'rt', 'rb', 'rw',  'kot', 'crm', 'acc');
//$r_list = array('rb', 'kot', 'kmod', 'pik', 'admin', 'site', 'acc', 'ripr');
$r_list = array('admin', 'site');
$reData_list = array('post', 'put', 'patch', 'delete');
//$emuMethod_list = array_merge(array('get'), $reData_list);
$emuMethod_list = array('get', 'post', 'put', 'patch', 'delete');



$Api = _rt::self();
$Api::$dbg = true && isLocalhost;
$Api::$dbg = false;

$requestHeaders = getallheaders();
$opt_contentType = prop($requestHeaders, 'Content-Type', '');
//$opt_accept = prop($requestHeaders, 'Accept', '');

$hasFormData = strpos($opt_contentType, 'multipart/form-data') !== false; //в запросе используется данные FormData
$hasJsonData = strpos($opt_contentType, 'application/json') !== false; //в теле запроса находится JSON
//$hasJsonData += strpos($opt_accept, 'application/json') !== false; //клиент ожидает JSON в ответе

//step: читаем входящие данные
$requestUri = strLess('/'.pageUri, $Api::uri('/'));
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestData = $_REQUEST;


if (!$hasFormData) {
	if (in_array(strtolower($requestMethod), $reData_list)) {
		//получаем данные из "сырого тело" запроса
		parse_str(file_get_contents('php://input'), $requestData);
	}
}

//dx($requestData, $_REQUEST, $requestMethod, $requestHeaders);

//если приходят JSON-данные
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
		/*
		case 'kot': case 'kmod': case 'pik': {
			include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
		} break;
		case 'admin': {
			include_once $_SERVER['DOCUMENT_ROOT'].'/ap/iq.inc';
		} break;
		case 'site': {
			include_once $_SERVER['DOCUMENT_ROOT'].'/gss3/iq.inc';
		} break;
		*/
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