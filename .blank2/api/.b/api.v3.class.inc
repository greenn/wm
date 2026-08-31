<?#4.0.11 L3
_needphp(
	'headers',
	'json'
);

_rt::reg('api', array(

));
/*
	_api('get', 'user/test'),
_api::get('user/test'),
function _api($method, $requestUri, $data = array(), $r = 'rp'){ //ak rp_api|r_api
	return rt_api::request($requestUri, $data, $method, $r);
}
*/
class _api {
	static $r = 'site';

	//oo metro-targets/r/metro.class.php
	static $dbg = false; //выводить dbg-данные в зависимости от этого значения
	static $dbgApi = true; //доступ к dbg-данным через параметр в данных dbg
	static $dbgMe = true; //доступ к dbg-данным через вызов isMe()
	static $dbgGet = true; //доступ к dbg-данным через параметр ?dbg


	static $routes = array();

	/*
		_api::addRoute('log', array('rw', 'tool-log'));
		_api::log('cur', array('tmp' => strtotime('-1 hours'))
		_api::log('test')
	*/
	static function addRoute($methodName, $ctx/*($r, $rName)*/){
		static::$routes[$methodName] = $ctx;
	}


	/*
		$item = metro_api::post('targets/target', array('target' => $target));
		$item2 = metro_api::post_data('targets/target', array('target' => $target));
		$item3 = metro_api::post_data_prop('target-id', 'targets/target', array('target' => $target));
		dx($item, $item2, $item3);

	*/
	static function __callStatic($method, $args_) {
		$r = static::$r;
		$methods = explode('_', $method); //tg
		$funcName = false;
		$funcArg1 = false;

		/*  #L2 вариант было до extends _api
			сейчас после _ идёт суб-метод
		if (count($methods) == 2) {
			list($r, $method) = $methods; //tg
		}
			ну значтьи addRoute надо убирать
				Т.К. он для другого не для self
		*/

		if (count($methods) == 2) {
			list($method, $funcName) = $methods; //tg
			if ($funcName !== 'data') {
				$funcArg1 = array_shift($args_);
			}
		}

		if (count($methods) == 3) {
			list($method, $funcNameChunk1, $funcNameChunk2) = $methods; //tg
			$funcName = join('_', array($funcNameChunk1, $funcNameChunk2));
			$funcArg1 = array_shift($args_);
		}

		$requestUri = prop($args_, 0, '');
		$data = prop($args_, 1, false);

		if ($preset = prop(static::$routes, $method)) {
			list($r, $rName) = $preset;
			$requestUri = $requestUri ? "$rName/$requestUri" : $rName;
			//as $requestUri = $rName . ($requestUri ? "/$requestUri" : '');
		}

		if (static::$dbgApi) {
			if (has_prop($data, 'dbg')) {
				static::$dbg = $data['dbg'];
			}
		}

		$response = rt_api::request($requestUri, $data, $method, $r);

		//d($funcName, $funcArg1);
		if ($funcName) switch ($funcName) {
			case 'prop': {
				//[nhm] return propChain($response, $funcArg1);
				return prop($response, $funcArg1);
			} break;
			case 'data': {
				return prop($response, 'data');
			} break;
			case 'data_prop': {
				return propChain($response, array('data', $funcArg1));
			} break;
		}
		return $response;
	}

	//static function response(){}
	//static function response_prop(){}


	static $response_errorDefTitle = 'Ответ Api';
	static $response_errorDefMsg = 'Ошибка';

	static function makeErrorCtx($ctx){
		if (!is_array($ctx)) $ctx = array('message' => $ctx);
		if (!has_prop($ctx, 'message')) $ctx['message'] = true;
		if (!has_prop($ctx, 'title')) $ctx['title'] = true;
		if ($ctx['message'] === true) $ctx['message'] = static::$response_errorDefMsg;
		if ($ctx['title'] === true) $ctx['title'] = static::$response_errorDefTitle;
		return $ctx;
	}
	//добавляет ошибку в стек ошибок
	//они будут храниться в errors, в response error будет true
	static function _response_error($ctx, &$response){
		if (!$ctx) return;
		$error = static::makeErrorCtx($ctx);
		if (!has_prop($response, 'errors')) {
			$response['errors'] = array();
		}
		$response['errors'] []= $error;
	}

	//анализируем и приводим response к общему виду
	static function _response_analyze(&$ctx, &$response){
		$state = array();
		$success = true;
		$error = false;

		if (has_prop($ctx, 'error')) {
			$error = $ctx['error'];
			//unset($ctx['error']); [L][22, но можно и оставить]
			if ($error) static::_response_error($error, $response);
		}


		if (has_prop($ctx, 'success')) {
			$res = $ctx['success'];
			unset($ctx['success']);
			$success = $res;
		} else if (has_prop($ctx, 'res')) {
			$res = $ctx['res'];
			unset($ctx['res']);
			$ctx['dbg-res'] = $res;
			$success = $res;
		} else {
			$success = !$error;
		}

		$state['success'] = !!$success || ($success === 0);
		$state['error'] = $error;



		//$response['state'] = $state;
		$response += $state; //L#V1/
		/*  #V2
				решили оставить для внутреннего api,
					т.к. для внешнего api.class добавляет в response
				а так будет постоянный уверенный
					$state['success']
					$state['error']

				а саму секцию 'state' решили убрать, т.к. ни кто её и ни как не использует
		*/
	}

	//обрабатываем dbg поля в респонсе
	static function _response_dbg(&$ctx, &$response, $dbg_extra = array(), $_opt = array()){ //_response_pick_dbg
		static $dbg_spec_props_db = array(
			'sql_last' => 'mc::last_sql',
			'sql_error' => 'mc::error',
		);

		$dbg_spec_props = array();
		if (prop($_opt, 'db')) {
		//if (prop($_opt, 'db') !== false) { //нет прямого указания не показывать dbg-db
			$dbg_spec_props += $dbg_spec_props_db;
		}

		static $dbg_props = array('hash', 'ajax');
		static $dbg_prop_prefix = 'dbg-';

		$dbg = prop($ctx, 'dbg', array());
		unset($ctx['dbg']);

		if (is_string($dbg_extra)) {
			$dbg_extra = explode(';', $dbg_extra);
		}
		if (is_string($dbg)) $dbg = explode(';', $dbg);
		if (isOrdinal($dbg)) {
			$dbg_extra = array_merge($dbg, $dbg_extra ? $dbg_extra : array());
			$dbg = array();
		}

		//step: собираем dbg контекст
		foreach($dbg_spec_props as $prop => $rule) {
			if ($value = prop($ctx, $prop)) {
				//step: проверяем в основном контексте
				unset($ctx[$prop]);
			} else if (!prop($dbg, $prop)) {
				//step: проверяем в dbg-контексте
				$value = prop($ctx, $prop);//данное свойство есть в ctx
				//dx($value, $rule, call_user_func($rule));
				if (!$value) {
					//step: получаем значение по умолчанию из $dbg_spec_props
					if (is_string($rule)) {
						$fn = $rule;
						$value = call_user_func($fn);
					} else {
						//dx('handle rule in dbg_spec_props, $rule, $prop)
					}
				}
			}
			//step: выставляем в dbg-контекст
			$dbg[$prop] = $value;
		}

		if (has_prop($dbg, 'sql_error')) {
			static::_response_error(array(
				'sql_error' => $dbg['sql_error']
			), $response);
		}

		foreach (array_merge($dbg_props, $dbg_extra) as $prop) {
			if (has_prop($ctx, $prop)) {
				$dbg[$prop] = $ctx[$prop];
				unset($ctx[$prop]);
			}
		}

		foreach ($ctx as $prop => $value) {
			if (startsWith($prop, $dbg_prop_prefix)) {
				$dbgProp = substr($prop, strlen($dbg_prop_prefix));
				$dbg[$dbgProp] = $ctx[$prop];
				unset($ctx[$prop]);
			}
		}

		if (static::$dbg || (static::$dbgGet && gt_on('dbg')) || (static::$dbgMe && isMe)) {
			$response['dbg'] = $dbg;
		}
	}



	static function response_res($res, $ctx = array(), $rules = array()){
		if (!$ctx) $ctx = array();
		$ctx['res'] = $res;
		return static::response($ctx, $rules);
	}

	static function response_error($error){
		return static::response(array('error' => $error));

	}

	static function response($ctx, $rules = array()){
		//$rules - дополнительные правила

		$response = array();

		static::_response_analyze($ctx, $response); //['state']

		static::_response_dbg($ctx, $response, false, array(
			'db' => prop($rules, 'db')
		)); //['dbg']

		//d($ctx, $response);

		//$response = array_merge($response, $ctx); //#V1 10
		$response['data'] = $ctx; //#V2 82
		/* [227] = буду менять / использовать новый вариант

			27+ есть данные в общим ответе
			27- данные менее труктурированныее
			27+ данными проще пользоваться "в дикую" / "на прямую"

			22+ данные более структурированныее
			22- простым api не удобно пользоваться, нужно вызывать свойство data, а потом ещё чторое свойства
				= но можно написать функции _data_prop

		*/

		return $response;
	}

	//проверка доступа
	//подразумевает, что нужен доступ
	static function getAccessError($ctx, $opt = array()){
		if (static::validateAccess($ctx, $opt)) {
			return false;
		} else {
			$error = array(
				'code' => '401 Unauthorized',
				'title' => 'Доступ закрыт',
				'status' => 401,
			);
			$error['message'] = "{$error['title']} ({$error['status']}) / {$error['code']}";
			return static::response_error($error);
		}
	}
	static function validateAccess($ctx, $opt = array()){
		$access_token = prop($ctx, 'access_token');
		return $access_token === true;
	}

}

class rt_api extends rt {
	static $dbg = false;

	static function apiUrl($uri = ''){
		static $url = false;
		if (!$url) $url = static::uri();
		if ($uri) $url .= "/".$uri;
		return $url;
	}

	static $requestData;
	static $requestMethod;
	static $requestUri;
	static $requestApiMethod;
	static $requestApi;
	static $requestError;

	//010
	static function request_info(){
		return array(
			'data' => static::$requestData,
			'method' => static::$requestMethod,
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


			if (is_file($methodPath)) {
				static::$requestApiMethod = true;
				$response = $r($rName, 'call', $methodFile, $data);
			} else if (is_file($apiPath)) {
				static::$requestApi = true;
				$response = $r($rName, 'call', $apiFile, $data);
			} else {
				static::$requestError = true;
				$response = array('error' => true, 'msg' => 'Wrong Api method');
				if (isMe) $response['path'] = $methodPath;
			}

		} else {
			static::$requestError = true;
			$response = array('error' => true, 'msg' => 'Wrong Api');
		}

		///dx($response);
		return $response;
	}

	//q
	static function response($requestUri, $data = array(), $method = 'POST', $r = 'rp'){
		$response = static::request($requestUri, $data, $method, $r);
		if (static::$outputMethod === 'outputJson') {
			//q uu bb
			if (!isset($response['error'])) $response['error'] = static::$requestError;
			if (!isset($response['success'])) $response['success'] = !$response['error'];
		}
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
	static function set_CORS($cfg, $index = 0){
		static::$CORS[$index] = $cfg;
	}

	static function use_CORS($index = 0){
		$cfg = prop(static::$CORS, $index);
		if ($cfg && is_array($cfg)) {
			//dx('use_CORS', $cfg);


			//prop($cfg, 'cors-origin-list')
			//$_SERVER['HTTP_ORIGIN']
			//in_array($_SERVER['HTTP_ORIGIN'], $allowed_domains

			if ($origin = prop($cfg, 'origin')) {
				//case: Разрешаем доступ с определённого домена
				if (is_array($origin)) $origin = join(', ', $origin);
				/*
					Вы не можете указать несколько доменов в заголовке Access-Control-Allow-Origin через запятую. Спецификация CORS допускает только один источник в этом заголовке для каждого ответа.
				*/

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
		print $isRaw ? $data : jsonPrettyEncode($data);
	}
}


class api_router {

}