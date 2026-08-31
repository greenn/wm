<?#4.0.11
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

	static $response_errorDefMessage = 'Ошибка';
	static $response_errorDefDescription = 'Ответ Api';


	static function makeErrorCtx($data, $ctx = array()){
		if (!is_array($data)) $data = array('message' => $data);
		if (is_array($ctx)) $data['ctx'] = $ctx + (is_array(prop($data, 'ctx')) ? $data['ctx'] : array());
		if (!has_prop($data, 'message')) $data['message'] = true;
		if (!has_prop($data, 'description')) $data['description'] = true;
		if ($data['message'] === true) $data['message'] = static::$response_errorDefMessage;
		if ($data['description'] === true) $data['description'] = static::$response_errorDefDescription;
		if (isset($data['ctx']) && !$data['ctx']) unset($data['ctx']); //удаляем пустой ctx
		return $data;
	}

	//добавляет ошибку в стек ошибок
	//они будут храниться в errors,
	// но в error будет true (после analyze)
	static function _responseError(&$response, $errorData){
		$error = static::makeErrorCtx($errorData);
		if (!has_prop($response, 'errors')) {
			$response['errors'] = array();
		}
		$response['errors'] []= $error;
	}

	static $optShowSuccessFlag = false; //L true
		//оказывается ниемоум не нужен success-flag
		//все проверяют на наличие только error

	//анализируем и приводим response к общему виду
	//сладковатый метод - выбирает данные, остальные помещает в 'data'
	static function makeResponseData($data, $opt = array()){
		$data0 = $data; //dbg
		$response = array();

		static $extProps = array('dbg');
		foreach ($extProps as $prop) {
			if (isset($data[$prop])) {
				$response[$prop] = $data[$prop];
				unset($data[$prop]);
			}
		}

		static $stateProps = array('success', 'error', 'errors');
		$state = array();

		foreach ($stateProps as $prop) {
			if (isset($data[$prop])) {
				$state[$prop] = $data[$prop];
				unset($data[$prop]);
			}
		}

		//if (isset($data['data'])) { }
		$response['data'] = $data;

		$hasSuccessData = has_prop($state, 'success');
		$successData = prop($state, 'success');

		$hasErrorData = has_prop($state, 'error');
		$errorData = prop($state, 'error');

		$hasErrorList = has_prop($state, 'errors');
		$errorList = prop($state, 'errors');


		$isError = ($hasSuccessData && !$successData) || $errorData || $errorList;
		$isSuccess = !$isError;

		if (static::$optShowSuccessFlag || $hasSuccessData) {
			$response['success'] = $isSuccess;
		}

		//dx($state, $data0, $isError);

		if ($isError) {
			if ($hasErrorList) {
				$response['errors'] = $errorList;
				$response['error'] = $errorData ? $errorData : true;
			} else {
				$response['error'] = $errorData ? $errorData : static::makeErrorCtx(true);;
				//so: то есть создаем дефолтную ошибку, только в редком случае, когда нет $error и нет $errorList
			}
		}

		return $response;
	}

	//обрабатываем dbg поля в response
	//данные свойств $dbg_props, $dbg_extra, и начинающиеся с $dbg_prop_prefix все будут перенесены в dbg
	//и показаны в зависимости от настроек $dbg
	static function _handleDbgData(&$data, $dbg_extra = array(), $_opt = array()){ //_response_pick_dbg
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
		static $dbg_prop_prefix = 'dbg:';

		if (is_string($dbg_extra)) {
			$dbg_extra = explode(';', $dbg_extra);
		}
		if (!is_array($dbg_extra)) $dbg_extra = array();


		$dbg = array();
		if (isset($data['dbg'])) {
			$dbgVal = $data['dbg'];
			unset($data['dbg']);
			if (is_string($dbgVal)) {
				$dbgVal = explode(';', $dbgVal);
			}
			if (isOrdinal($dbgVal)) {
				$dbg_extra = array_merge($dbgVal, $dbg_extra);
			} elseif (is_array($dbgVal)) {
				$dbg = $dbgVal;
			}
		}


		//Section: собираем dbg контекст

		//собираем указанные dbg-свойства
		foreach (array_merge($dbg_props, $dbg_extra) as $prop) {
			if (has_prop($data, $prop)) {
				$dbg[$prop] = $data[$prop];
				unset($data[$prop]);
			}
		}

		//собираем dbg-свойства начинающиеся с префикса
		foreach ($data as $prop => $value) {
			if (startsWith($prop, $dbg_prop_prefix)) {
				$dbgProp = substr($prop, strlen($dbg_prop_prefix)); //отрезаем префикс
				$dbg[$dbgProp] = $data[$prop];
				unset($data[$prop]);
			}
		}

		//step: проходимся по специальным свойствам
		foreach($dbg_spec_props as $specProp => $rule) {
			$value = null;
			if (isset($data[$specProp])) { //проверяем значение спец-свойство в основном контексте
				$value = $data[$specProp];
				unset($data[$specProp]);
			} elseif (!has_prop($dbg, $specProp)) { //если значения нет в dbg-контексте
				//step: получаем значение по умолчанию из $dbg_spec_props
				if (is_callable($rule)) {
					$value = call_user_func($rule);
				}
			}

			//step: выставляем в dbg-контекст
			$dbg[$specProp] = $value;
		}

		if (static::$dbg || (static::$dbgGet && gt_on('dbg')) || (static::$dbgMe && isMe)) {
			$data['dbg'] = $dbg;
		}

		if ($sql_error = prop($dbg, 'sql_error')) {
			static::_responseError($data, array(
				'sql_error' => $sql_error
			));
		}

	}

	static function response_error($error, $errorCtx = false, $responseCtx = array()){
		if (!is_array($responseCtx)) $responseCtx = array();
		$responseCtx['error'] = static::makeErrorCtx($error, $errorCtx);
		return static::response($responseCtx);
	}

	static function response($ctx, $opt = array()){
		//d('response/0', $ctx);
		if ($ctx === true) $ctx = array('success' => true);
		if ($ctx === false) $ctx = array('error' => true);
		if (!$ctx) $ctx = array();

		static::_handleDbgData($ctx, $opt,  false, array(
			'db' => prop($opt, 'db')
		));

		return static::makeResponseData($ctx);
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

/*
	DD-PREV-v3

	_api('get', 'user/test'),
_api::get('user/test'),
function _api($method, $requestUri, $data = array(), $r = 'rp'){ //ak rp_api|r_api
	return rt_api::request($requestUri, $data, $method, $r);
}
*/

