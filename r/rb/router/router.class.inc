<?#2.3.0

_rb::reg('router', array(
	'nc' => array(
		'base' => 'R'
	),
));

class rb_router extends rb {

	static function handle($uri = true, $isRootPid = false) {
		//L-eg \<< re
		_router::applyHandlerByUri($uri, $isRootPid);
	}

	static function processPath($handlerPath, $ctx) {
		$tplPath = array($handlerPath); //указываем на прямой путь темплейта (т.к. здесь он сторонний/внешний - директория router)
		//dx($tplPath, is_file($tplPath[0]), $ctx);
		print static::tpl($tplPath, $ctx);
	}

	static function process($handlerName, $ctx) {
		$routerPath = _router::handlerPath($handlerName);
		//dx($routerPath, is_file($routerPath));
		static::processPath($routerPath, $ctx);
	}

	//oo r/rb/router/router.eg-1.php
	static function tempPidCtx($defValues = array(), $defPid = true){
		$pidValues = array(
			'Pid' => false,
			'pid' => $defPid, //ak $modPid
			'subUri' => pageUri,
		);

		$_ctx = static::tempCtx($defValues + $pidValues);
		//dx($_ctx, $defValues + $pidValues);

		//case base
		$Pid = $_ctx['Pid']; //через applyHandlerByUri

		//case custom
		$pid = $_ctx['pid'];
		//dx($pid, $Pid);
		$uri = $_ctx['subUri'];
		if (!$Pid) {
			$Pid = new pid("$pid/$uri");
			//dx($Pid, "$pid/$uri");
		}

		$_ctx['Pid'] = $Pid;
		$_ctx['pid'] = $Pid->name;

		return $_ctx;
	}



	//static $emptyContentValue = array('content-tpl' => 'uc');
	static $emptyContentValue = array('content' => '');

	static function collectContentCtx($pageData, $pageCtx = array()){
		if ($contentTpl = _prop($pageData, 'content-tpl')) {
			$pageCtx['content-tpl'] = $contentTpl;
		}

		if ($content = _prop($pageData, 'content')) {
			if (is_array($content)) {
				$pageCtx += $content;
			} else {
				$pageCtx['content'] = $content;
			}
		}

		if ($contents = _prop($pageData, 'contents')) {
			$pageCtx['contents'] = $contents;
		}


		if (!$pageCtx && !$contentTpl && !$content && !$contents) {
			$pageCtx += static::$emptyContentValue;
		}
		return $pageCtx;
	}

	//ddj
	static function _updateCtx($pageData, &$pageCtx = false, &$appCtx = false, &$htmlCtx = false){
		$pageCtxData =  _prop($pageData, 'page-ctx');
		$appCtxData =  _prop($pageData, 'app-ctx');
		$htmlCtxData =  _prop($pageData, 'html-ctx');

		$pageCtx = array_replace($pageCtx, $pageCtxData);

	}

	

	//PageHtmlCtx
	//готовим контекст из данных роутера
	//= prepareRouterCtx
	static function prepareRootCtx($ctx){
		//$pid = $ctx['use-pid'];
		$pid = _prop($ctx, 'use-pid');

		if ($pid) {
			$ctx = static::collectPageCtxById($pid);
			//dx($pid, $ctx);
		}

		$resCtxs = static::takePageCtx($ctx);
		return $resCtxs;
	}

	//собираем контекст для site_tpl('page', 'html') по pid страницы
	static function collectPageCtxById($pid){
		$pageData = _page($pid);
		$pageData['pid'] = $pid; //':pid'
		return static::collectPageCtx($pageData);
	}


	//собираем контекст для site_tpl('page', 'html') из данных
	//работаем с Данными Страницы, формируем контекст для темплейта
	static function collectPageCtx($ctxData){

		$pageCtx = _prop($ctxData, 'page-ctx', array());
		$pageCtx0 = $pageCtx;
		$pageCtx['pid'] = _prop($ctxData, 'pid');
		$pageCtx = rb_router::collectContentCtx($ctxData, $pageCtx);
		//dx($pageCtx0, $pageCtx);

		$contentTitle = static::handleContentTitle($ctxData);
		$pageTitle = static::handlePageTitle($ctxData);
		//dx($pageTitle);


		$ctxData['page-ctx'] = $pageCtx;
		$ctxData['content-title'] = $contentTitle;
		$ctxData['page-title'] = $pageTitle;

		$htmlCtx = _prop($ctxData, 'html-ctx', array());
		$htmlCtx['seo'] = static::handlePageSeo($ctxData); //, $htmlCtx) + _prop($htmlCtx, 'seo', array());
		$htmlCtx['og'] = static::handlePageOg($ctxData);
		$ctxData['html-ctx'] = $htmlCtx;
		//dx($ctxData);
		return $ctxData;
	}

	//разносим сформированные данные страницы по конфигам для site_tpl('page', 'html')
	static function takePageCtx($ctxData){

		$htmlCtx = _prop($ctxData, 'html-ctx', array());
		$pageCtx = _prop($ctxData, 'page-ctx', array());
		$appCtx =  _prop($ctxData, 'app-ctx', array());

		$contentTitle = _prop($ctxData, 'content-title');
		$pageTitle = _prop($ctxData, 'page-title');

		$content = _prop($ctxData, 'content');
		if ($content) {
			$pageCtx['content'] = $content;
		}


		$pageCtx['content-title'] = $contentTitle;
		$htmlCtx['pageTitle'] = $pageTitle;
		//$htmlCtx['pageTitle'] = '*'.$pageTitle;


		return array($htmlCtx, $pageCtx, $appCtx, $ctxData);
	}


	// собираем seo-данные
	static function handlePageSeo($ctxData){
		$seoCtx = _prop($ctxData, 'seo', array());

		if (_prop::has($ctxData, 'sitemap')) {
			$seoCtx['norobots'] = _prop($ctxData, 'sitemap') === false;
		}

		return $seoCtx;
	}

	static function handleContentTitle($ctxData){
		$contentTitle = _prop::pikIn($ctxData, 'title', array('content', '-page'));
		return $contentTitle;
	}

	static function handlePageTitle($ctxData){
		$pageTitle = _prop::pikIn($ctxData, 'title', array('page', 'content'));
		//$pageTitle = _page::pageTitle(array($pageTitle, $modTitle));
		$pageTitle = _page::pageTitle($pageTitle);
		return $pageTitle;
	}

	static function handlePageOg($ctxData){
		$ogCtx = array();
		$ogSet = pro('og');

		if ($ogSet && _prop($ogSet, 'usage')) {
			$ogCtx = _prop($ctxData, 'og', array());
			$pid = $ctxData['pid'];


			if (!_prop::has($ogCtx, 'url')) {
				$ogCtx['url'] = page($pid, 'link', true) ?: true;
			}

			if (!_prop::has($ogCtx, 'title')) {
				$baseTitle = $ctxData['page-title'];
				$seoTitle = _prop(_prop($ctxData, 'seo'), 'title');
				$ogCtx['title'] = $seoTitle ?: $baseTitle ?: _pro('base-title');
			}

			if (!_prop::has($ogCtx, 'description')) {
				$seoDescription = _prop(_prop($ctxData, 'seo'), 'description');
				if ($seoDescription) {
					$ogCtx['description'] = $seoDescription;
				}
			}

			$ogImg = _prop($ogCtx, 'image', pro('og', 'base_img'));
			$ogCtx['image'] = _i::hostUri($ogImg);

			if (!_prop::has($ogCtx, 'type')) {
				$ogCtx['type'] = 'website';
			}

		}
		return $ogCtx;
	}
	

}
