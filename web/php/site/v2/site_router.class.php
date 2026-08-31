<?#4.0.1 - site router

//pro, page
//_needphp();


//_rb::req('router'); - здесь ещё нету r/ iq/php/iq.class.php:55
//L oo r/rb/router/router.class.inc
class site_router {

	static $proSid = true;

	static $handler_base = 'site';
	static $handler_404 = 'http-404';

	static $pageCtx = array();
	
	//логика орбработчика, что он есть в базовом варианте в директории iq/router
	//либо пользовательской iq/config/router
	//в теории отклюбчение базовых роутеров, можно сделать через флаг $noBaseRouter
	static function handlerPath($handlerName, $type = null){
		//if (static::$noBaseRouter) $type = true; //Lp вариант

		$basePath = PHP."/site/v2/router/$handlerName.php";
		$userPath = pro('routerDir')."/router/$handlerName.php";

		$getBase = $type === false;
		$getUser = $type === true;
		$autoCase = $type === null; //автовыбор: сперва пользовательский
		if ($autoCase) {
			$getUser = is_file($userPath);
		}
		return $getUser ? $userPath : $basePath;
	}
	static function isHandler($handlerName, $type = null){
		return is_file(static::handlerPath($handlerName, $type));
	}

	static function getDefaultHandler($asPath = true, $existPage = true){
		$handlerName = $existPage ? static::$handler_base : static::$handler_404;
		return $asPath ? static::handlerPath($handlerName) : $handlerName;
	}

	static function resolveHandlerNameByPid($pid, $useDefault = true){
		//step: определяем hand
		//ler (handlerName|routerPage)
		$handlerName = false;
		$handlerCtx = false;

		$hasPid = cur('pages', 'hasPid', $pid);

		if ($hasPid) { //case: если есть прямые данные у страницы (указывающие на роутер)
			$handlerName = _pageData($pid, 'router');
			$handlerCtx = _pageData($pid, 'router-ctx');
		}

		if ($redirect = static::verifyHandlerRedirectByPageData($pid)) {
			list($handlerName) = $redirect;
		}

		//пробуем найти указание на собственный handler-файл
		if (!$handlerName) {//case: handlerName явно не указан в конфиге самой страницы
			$handlerName = $pid;
		}

		//проверяем существование такого обработчика
		//dx($pid, $handlerName, static::isHandler($handlerName));
		if (!static::isHandler($handlerName)) {
			if ($useDefault) {
				$handlerName = static::getDefaultHandler(false, $hasPid);
			} else {
				$handlerName = false;
			}
		}

		//dx($handlerName, $handlerCtx, static::$pageCtx);

		//добавляем в контекстСтраницы данные из данных-страницы
		if ($handlerCtx) {
			static::$pageCtx += $handlerCtx;
		}

		return $handlerName;
	}

	static $autoRedirectToRelUri = !true;
	static function verifyHandlerRedirectByUri($uri){
		//проверям является есть ли у ссылки canonical-референс
		list($hasRel, $relUri, $isRel) = cur('pages', 'hasRelUri', $uri, true);
		if(0) _pages::hasRelUri();
		///d($uri, $hasRel, $relUri, $isRel);

		// если ест референс и данный $uri не canonical
		if ($hasRel && !$isRel) {
			//step: resolveRedirect
			dx($uri, $relUri, static::$autoRedirectToRelUri);
			if (static::$autoRedirectToRelUri) {
				static::applyHandler('redirect', array(
					'uri' => "/$relUri",
					'code' => 301, //постоянное перенаправление
				));
				return true;
			} else {
				//d('hasRedirectedUri', $uri, $redirectPid); //dbg
			}
		}
	}

	static function verifyHandlerRedirectByPageData($pid){
		$redirect = _pageData($pid, 'redirect');
		if ($redirect) {
			$handlerName = 'redirect'; //меняем обработчик запроса у роутера
			$redirect = (array) $redirect;
			static::$pageCtx['uri'] = $redirect[0];
			if (isset($redirect[1])) {
				static::$pageCtx['code'] = $redirect[1] === true ? 301 : $redirect[1];
			}
			return array($handlerName);
		}
	}

	//определяем есть ли переназначение для pid
	static function verifyHandlerOverlap($pid){
		$overlap_pid = data_opt('overlap_pid'); //case: глобальный overlap
		//d($overlap_pid);
		if (data_opt('overlap_off_forMe') && isMe) $overlap_pid = false;
		//d($overlap_pid);
		if (data_opt('overlap_off_forLocalhost') && isLocalhost) $overlap_pid = false;
		//d($overlap_pid);
		if (!$overlap_pid) {
			//case: частный overlap
			//dx($pid);
			$overlap_pid = _pageData($pid, 'overlap');
			//dx($overlap_pid);
		}
		//dx($overlap_pid);

		if ($overlap_pid) { //case extra:
			//if ($overlap_pid === true) $overlap_pid = 'overlap';
			$doOverlap = true;

			$overlapOpt = _pageData($pid, 'overlap-opt');
			//_x('dbg1', 1); dx(_page($pid));
			$skipOverlap = $overlapOpt === false || $overlapOpt === 'skip';
			//dx($pid, $overlapOpt, $skipOverlap);
			if ($skipOverlap) {
				$doOverlap = false;
			}

			if ($doOverlap) {
				//case: overlapPid есть, а исключений для него нету
				//res: перекрывавем
				return $overlap_pid;
			}
		}
	}


	//выполянем проверки с uri
	static function resolveUri($uri){

		$uri0 = $uri;
		if ($uri === '') {
			$uri = data_opt('base_pid');
		}

		static::verifyHandlerRedirectByUri($uri);

		if ($overlapUri = static::verifyHandlerOverlap($uri)) {
			$uri = $overlapUri;
		}

		return $uri;
	}

	//создать объект данных страницы
	//[lb _pid] | makeUriObject
	static function page_uri($uri = true, $pagesClass = true){
		if ($uri === true) $uri = pageUri;
		if ($uri === '') {
			$uri = data_opt('base_pid');
		}

		$uri = urldecode($uri);
		$uri = mb_strtolower($uri);

		if ($pagesClass === true) $pagesClass = _proOptEnv(true, 'pages');

		$Uri = new page_uri($uri, $pagesClass);

		return $Uri;
	}

	//запускаем обработчик по uri
	static function applyHandlerByUri($uri = true, $setAsCur = false){
		$uri0 = $uri;
		if ($uri === true) $uri = pageUri;

		$uri = static::resolveUri($uri);

		//$uri = 'catalog/groby/3-lavr-kosa';
		$Uri = static::page_uri($uri);
		//dx($Uri, $Uri->name, $Uri->Page);

		//определил идентификатор страницы
		$pid = $Uri->name;

		if ($setAsCur) {
			cur('pages', 'curUriSet', $Uri);
		}

		//dx(pageUri, $uri, $Pid->name, $pid);

		static::$pageCtx = array(
			'use-pid' => $pid,
			'Uri' => $Uri,
		);

		$handlerName = self::resolveHandlerNameByPid($pid); //получаем path для обработчика входящего запроса
		//dx($pid, $handlerName, static::$pageCtx);

		static::applyHandler($handlerName, static::$pageCtx);
	}

	static function applyHandler($handlerName, $handlerCtx){
		$handler = static::handlerPath($handlerName);
		//dx($handler, $handlerCtx);

		//запускаем обработчик через RB_ROUTER2
		_rb::req('router2');
		rb_router2::processPath($handler, $handlerCtx);
	}


	static function uc($title = true, $tmRetry = true){
		if ($title === true) {
			$title = 'На сайте ведутся технические работы';
		}
		if ($tmRetry === true) {
			$tmRetry = 1 * 3600; // 1 час (3600 секунд)
		}
		header("X-Robots-Tag: noindex, nofollow");
		http_response_code(503);
		header("Retry-After: $tmRetry");
		print $title;
		exit;
	}

}