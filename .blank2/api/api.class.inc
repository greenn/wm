<?#4.0.11
_needphp(
	'headers',
	'json'
);

include_once '_api.class.php';

_rt::reg('api', array(

));

class rt_api extends rt {
	static $dbg = false;

	static function apiUrl($uri = ''){
		static $url = false;
		if (!$url) $url = static::uri();
		if ($uri) $url .= "/".$uri;
		return $url;
	}

	static $requestR;
	static $requestData;
	static $requestMethod;
	static $requestUri;
	static $requestApiMethod;
	static $requestApi;
	static $requestError;

	static $prettyJson = true;

	//010
	static function request_info(){
		return array(
			'data' => static::$requestData,
			'method' => static::$requestMethod,
			'r' => static::$requestR,
			'uri' => static::$requestUri,
			'api-method' => static::$requestApiMethod,
			'api' => static::$requestApi,
			'error' => static::$requestError,
		);
	}

	static function request($requestUri, $data = array(), $method = 'POST', $r = 'rp'){
		//$rootApi = strpos($requestUri, '/') === false;
		$rName = strtok($requestUri, '/');
		$api = strLess($requestUri, $rName.'/');

		static::$requestR = $r;
		static::$requestData = $data;
		static::$requestMethod = $method;
		static::$requestUri = $requestUri;
		static::$requestApiMethod = false;
		static::$requestApi = false;
		static::$requestError = false;

		$apiFile = "api/$api";
		$methodFile = join('.', array($apiFile, strtolower($method)));
		//d($apiFile, $methodFile);


		//if (_rp::req($rName)) {
		//проверяем наличие ресурса

		if (call_user_func("_$r::req", $rName)) {

			$methodPath = $r($rName, 'path',  "$methodFile.inc");
				//as $methodPath = rp($rName, 'path',  "$methodFile.inc");
				//ak $methodPath = call_user_func($r, $rName, 'path',  "$methodFile.inc");

			$apiPath = $r($rName, 'path',  "$apiFile.inc");
			//d($apiPath, $methodPath);
			//dx($requestUri, $api, $apiFile, is_file($apiPath), $methodFile, is_file($methodPath));
			//dx($requestUri, $api, $apiFile, $apiPath, is_file($apiPath), $methodFile, is_file($methodPath), $methodPath);


			//dx($methodPath);
			if (is_file($methodPath)) {
				static::$requestApiMethod = true;
				$response = $r($rName, 'call', $methodFile, $data);
			} else if (is_file($apiPath)) {
				static::$requestApi = true;
				$response = $r($rName, 'call', $apiFile, $data);
			} else {
				static::$requestError = true;
				//$response = array('error' => true, 'msg' => 'Wrong Api method');
				$response = array('error' => array('message' => 'Wrong Api method'));
				if (isMe) $response['path'] = $methodPath;
			}

		} else {
			static::$requestError = true;
			//$response = array('error' => true, 'msg' => 'Wrong Api');
			$response = array('error' => array('message' => 'Wrong Api'));
		}

		//dx($response);
		return $response;
	}

	//q
	static function response($requestUri, $data = array(), $method = 'POST', $r = 'rp'){
		$response = static::request($requestUri, $data, $method, $r);
		//dx($response, static::$outputMethod);

		/*
			//L3
			if (static::$outputMethod === 'outputJson') {
				//q uu bb
				if (!isset($response['error'])) $response['error'] = static::$requestError;
				if (!isset($response['success'])) $response['success'] = !$response['error'];
			}
		*/


		return $response;
	}

	/*
	static function get($api, $data = array()){
		return static::response($api, $data, 'GET');
	}
	static function post($api, $data = array()){
		return static::response($api, $data, 'POST');
	}
	*/

	static $CORS = array();
	static function set_CORS($cfg){
		static::$CORS = $cfg;
	}

	static function use_CORS(){
		_needphp('x.class/_x'); //dbg

		if ($cfg = static::$CORS) {
			//dx('use_CORS', $cfg);

			$origin = prop($cfg, 'origin');

			if ($originList = prop($cfg, 'origin-list')) {
				if (isset($_SERVER['HTTP_ORIGIN'])) {
					if (in_array($_SERVER['HTTP_ORIGIN'], $originList)) {
						$origin = $_SERVER['HTTP_ORIGIN'];
					}
				}
			}
			//dx($cfg, $origin, $originList);

			if ($origin) {
				//case: Разрешаем доступ с определённого домена
				if (is_array($origin)) $origin = join(', ', $origin);
				/*
					Вы не можете указать несколько доменов в заголовке Access-Control-Allow-Origin через запятую. Спецификация CORS допускает только один источник в этом заголовке для каждого ответа.
				*/
				_x('Access-Control-Allow-Origin', $origin);
				header("Access-Control-Allow-Origin: $origin");
			}


			if ($cookies = prop($cfg, 'cookies')) {
				//case: разрешаем отправку cookies
				header('Access-Control-Allow-Credentials: true');
			}
			if ($methods = prop($cfg, 'methods')) {
				//case: разрешённые методы отправки: eg GET, POST, PUT, DELETE
				header("Access-Control-Allow-Methods: $methods");
			}
			if ($headers = prop($cfg, 'headers')) {
				//case: Разрешаем заголовки, которые могут быть использованы в запросе
				header("Access-Control-Allow-Headers: $headers");
			}
		}
	}

	static $outputMethod = 'outputJson';
	//static $outputAsJs = false;
	static function output($data, $isRaw = false){
		//$args = func_get_args();
		static::use_CORS();
		$method = static::$outputMethod;
		call_user_func_array("static::$method", func_get_args());
	}

	static function outputJs($data){
		headers('js', 'utf8', 'nosniff');
		print $data;
	}

	static function outputJson($data, $isRaw = false){
		headers('json', 'utf8', 'nosniff');
		//dx(headers::$last, headers::$rawLast);
		print $isRaw ? $data : (static::$prettyJson ? jsonPrettyEncode($data) : json_encode($data, JSON_UNESCAPED_UNICODE));
	}
}


class api_router {

}