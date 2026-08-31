<?#3.4.4 - site router

//pro, page
//_needphp();


//_rb::req('router'); - здесь ещё нету r/ iq/php/iq.class.php:55
//L oo r/rb/router/router.class.inc
class _router {

	static $handler_base = 'site';
	static $handler_404 = 'http-404';

	//логика орбработчика, что он есть в базовом варианте в директории iq/router
	//либо пользовательской iq/config/router
	//в теории отклюбчение базовых роутеров, можно сделать через флаг $noBaseRouter
	static function handlerPath($handlerName, $type = null){
		//if (static::$noBaseRouter) $type = true; //Lp вариант
		$autoCase = $type === null;
		$basePath = pro('proDir')."/router/$handlerName.php";
		$rebasePath = pro('configDir')."/router/$handlerName.php";
		if (_x('hkIqRouter')) $rebasePath = _x('hkIqRouter')."/$handlerName.php";

		//d($handlerName, is_file($basePath), $basePath, is_file($rebasePath), $rebasePath);

		if ($autoCase) {
			$hasRebase = is_file($rebasePath);
			return $hasRebase ? $rebasePath : $basePath;
		} else {
			$getBase = $type === false;
			$getRebase = $type === true;
			return $getBase ? $basePath : $rebasePath;
		}
	}
	static function isHandler($handlerName, $type = null){
		return is_file(static::handlerPath($handlerName, $type));
	}

		//d
		static $handler_base_map = array(
			''
		);
		static function getBaseHandler(){
			//each $handler_base_map
			//startWith
			return static::$handler_base;
		}

	static function getDefaultHandler($asPath = true, $forPage = true){
		$handlerName = $forPage ? static::$handler_base : static::$handler_404;
		return $asPath ? static::handlerPath($handlerName) : $handlerName;
	}

	static function getHandlerByPid($pid, $useDefault = true){
		//step: определяем handler (handlerName|routerPage)
		$handlerName = false;
		$handlerCtx = false;
		$redirect = false;

		$hasPid = !!_page($pid); //ak hasPageData
		//dx($pid, $hasPid);

		if ($hasPid) { //case: если есть прямые данные у страницы (указывающие на роутер)
			$handlerName = _page($pid, 'router');
			$handlerCtx = _page($pid, 'router-ctx');
			$redirect = _page($pid, 'redirect');
			//dx($pid, $handlerName, $redirect);
		}
		//dx($pid, $hasPid, $handlerName);

		if ($redirect) {
			$handlerName = 'redirect'; //меняем обработчик запроса у роутера
			$redirect = (array) $redirect;
			static::$ctx['uri'] = $redirect[0];
			if (isset($redirect[1])) {
				static::$ctx['code'] = $redirect[1] === true ? 301 : $redirect[1];
			}
		}


		//пробуем найти прямой router-файл
		if (!$handlerName) {//case: handler явно не указан в конфиге самой страницы
			$handlerName = $pid;
		}

		if (!static::isHandler($handlerName)) {
			if ($useDefault) {
				$handlerName = static::getDefaultHandler(false, $hasPid);
			} else {
				$handlerName = false;
			}
		}

		//dx($handlerName, $handlerCtx);

		if ($handlerCtx) {
			static::$ctx += $handlerCtx;
		}

		return $handlerName;
	}

	static $autoRedirectToRelUri = !true;
	static $ctx = array();
	static function verifyHandlerRedirect($pid){
		list($hasRel, $relUri, $isRel) = _page::hasRelUri($pid, true);
		///d($pid, $hasRel, $relUri, $isRel);
		if ($hasRel && !$isRel) {
			return $relUri;
		}
		return false;
	}

	//определяем есть ли переназначение для pid
	static function verifyHandlerOverlap($pid){
		$overlap_pid = pro('opt', 'overlap_pid'); //case: глобальный overlap
		//d($overlap_pid);
		if (pro('opt', 'overlap_off_forMe') && isMe) $overlap_pid = false;
		//d($overlap_pid);
		if (pro('opt', 'overlap_off_forLocalhost') && isLocalhost) $overlap_pid = false;
		//d($overlap_pid);
		if (!$overlap_pid) {
			//case: частный overlap
			$overlap_pid = _page($pid, 'overlap');
			//dx($overlap_pid);
		}
		//dx($overlap_pid);

		if ($overlap_pid) { //case extra:
			//if ($overlap_pid === true) $overlap_pid = 'overlap';
			$doOverlap = true;

			$overlapOpt = _page($pid, 'overlap'); //'overlap-opt'
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

		return false;
	}


	static function resolvePageId($pid = pageUri){
		$redirectPid = static::verifyHandlerRedirect($pid);
		if ($redirectPid) {
			if (static::$autoRedirectToRelUri) {
				static::applyHandler('redirect', array(
					'uri' => "/$redirectPid",
					'code' => 301, //постоянное перенаправление
				));
				return;
			} else {
				//d('hasRedirectedUri', $pid, $redirectPid); //dbg
			}
		}

		$overlapPid = static::verifyHandlerOverlap($pid);
		//dx($overlapPid);
		if ($overlapPid) {
			$pid = $overlapPid;
		}

		return $pid;
	}

	static function applyHandlerByUri($uri = true, $setAsCur = false){
		$Pid = _pid::create($uri, $setAsCur);
		//dx($Pid, $Pid->name);

		$pid = static::resolvePageId($Pid->name);
		//dx(pageUri, $uri, $Pid->name, $pid);

		static::$ctx = array(
			'Pid' => $Pid,
			'pid' => $pid,
			'use-pid' => $pid, //al true \q 'al true'
		);

		$handlerName = _router::getHandlerByPid($pid); //получаем path для обработчик входящего запроса
		//dx($handlerName, static::$ctx);
		static::applyHandler($handlerName, static::$ctx);
	}

	static function applyHandler($handlerName, $handlerCtx){
		$handler = static::handlerPath($handlerName);
		//dx($handler, $handlerCtx);
		rb('router', 'processPath', $handler, $handlerCtx);
	}

	static function applyHandler_v1($handlerName, $handlerCtx){
		$handler = static::handlerPath($handlerName);
		$ctx = $handlerCtx;
		include $handler;
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

if (pro('opt', 'router-def')) _router::$handler_base = pro('opt', 'router-def');
if (pro('opt', 'router-404')) _router::$handler_404 = pro('opt', 'router-404');