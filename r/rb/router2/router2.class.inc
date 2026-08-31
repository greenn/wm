<?#2.4.1 - router для web19 (чтобы старый был для L)

_rb::reg('router2', array(
	'nc' => array(
		'base' => 'R'
	),
));

class rb_router2 extends rb {

	static function processPath($handlerPath, $ctx) {
		$tplPath = array($handlerPath); //указываем на прямой путь темплейта (т.к. здесь он сторонний/внешний - директория router)
		//dx($tplPath, is_file($tplPath[0]), $ctx);
		print static::tpl($tplPath, $ctx);
	}

	static function process($handlerName, $ctx) {
		$routerPath = site_router::handlerPath($handlerName);
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
		//case: 'content-tpl'
		if ($contentTpl = _prop($pageData, 'content-tpl')) {
			$pageCtx['content-tpl'] = $contentTpl;
		}

		//case: 'content'
		if ($content = _prop($pageData, 'content')) {
			if (is_array($content)) {
				$pageCtx += $content;
			} else {
				$pageCtx['content'] = $content;
			}
		}

		//case: 'contents'
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
	static function getPageDataCtx($ctx){
		$pid = _prop::pik($ctx, array('use-pid', 'pid'));
		$Page = _prop($ctx, 'Page');
		$pageData = _prop($ctx, 'page-data');
		if ($pid) {
			if (!$Page) {
				$Page = cur('pages', 'get', $pid);
			}
			if (!$pageData) {
				$pageData = $Page->data;
			}
			$pageData['pid'] = $pid;
		}
		return array($pid, $pageData ?: array(), $Page);
	}

	static function prepareRootCtx($ctx){
		//$pid = $ctx['use-pid'];
		//static::getPageDataCtx();
		list($pid, $pageData, $Page) = static::getPageDataCtx($ctx);
		$ctx = static::collectPageCtx($pageData, $Page);

		$resCtxs = static::takePageCtx($ctx);
		return $resCtxs;
	}

	//собираем контекст для site_tpl('page', 'html') по pid страницы
	static function collectPageCtxById($pid){
		$pageData = _pageData($pid);
		$pageData['pid'] = $pid; //':pid'
		return static::collectPageCtx($pageData);
	}


	//собираем контекст для site_tpl('page', 'html') из данных
	//работаем с Данными Страницы, формируем контекст для темплейта
	static function collectPageCtx($pageData, $Page = false){
		$ctxData = $pageData;

		//step: формируем page-ctx
		$pageCtx = _prop($pageData, 'page-ctx', array());
		$pageCtx0 = $pageCtx;
		$pageCtx['pid'] = _prop($pageData, 'pid');
		$pageCtx = static::collectContentCtx($ctxData, $pageCtx);
		//dx($pageCtx0, $pageCtx);
		$ctxData['page-ctx'] = $pageCtx;

		//step: формируем доп-данные
		$contentTitle = static::handleContentTitle($pageData);
		$pageTitle = static::handlePageTitle($pageData);
		//dx($pageTitle);
		$ctxData['content-title'] = $contentTitle;
		$ctxData['page-title'] = $pageTitle;

		//step: формируем html-ctx
		$htmlCtx = _prop($pageData, 'html-ctx', array());
		$htmlCtx['seo'] = static::handlePageSeo($ctxData); //, $htmlCtx) + _prop($htmlCtx, 'seo', array());
		$htmlCtx['og'] = static::handlePageOg($pageData, $Page);
		$ctxData['html-ctx'] = $htmlCtx;

		//dx($ctxData);
		return $ctxData;
	}

	//разносим сформированные данные страницы по конфигам: html-ctx, page-ctx, app-ctx
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

	static function handleContentTitle($pageData){
		$contentTitle = _prop::pikIn($pageData, 'title', array('content', '-page'));
		return $contentTitle;
	}

	/*
		здесь $ctxData, это полученные данные по pid,
		для отображения

	*/
	static function handlePageTitle($pageData){
		//Получаем title-данные ид данных-страницы
		$rawPageTitle = _prop::pikIn($pageData, 'title', array('page-raw'));
		if ($rawPageTitle) {
			$pageTitle = $rawPageTitle;
		} else {
			//base case: Формируем Заголовок через общего менеджера
			$titleText = _prop::pikIn($pageData, 'title', array('page', 'content'));
			$pageTitle = _page::pageTitle($titleText);
		}
		//dx($rawPageTitle, $pageTitle, @$titleText);

		return $pageTitle;
	}

	static function handlePageOg($ctxData, $Page = false){ /*, $Page*/
		$ogCtx = array();
		$ogSet = pro('og');

		if ($ogSet && _prop($ogSet, 'usage')) {

			$ogCtx = _prop($ctxData, 'og', array());
			$pid = $ctxData['pid'];
			if (!$Page) $Page = pro_page($pid); //объект данных для данной страницы

			if (!_prop::has($ogCtx, 'url')) {
				//$ogCtx['url'] = pro_page($pid, 'link', true) ?: true;
				$ogCtx['url'] = $Page->link(true) ?: true;
			}

			if (!_prop::has($ogCtx, 'title')) {
				$baseTitle = $ctxData['page-title'];
				$seoTitle = _prop($ctxData, array('seo', 'title'));
				$ogCtx['title'] = $seoTitle ?: $baseTitle ?: _pro('base-title');
			}

			if (!_prop::has($ogCtx, 'description')) {
				$seoDescription = _prop($ctxData, array('seo', 'description'));
				if ($seoDescription) {
					$ogCtx['description'] = $seoDescription;
				}
			}

			$ogImg = _prop($ogCtx, 'image', data_opt('og', 'base_img'));
			$ogCtx['image'] = _i::hostUri($ogImg);

			if (!_prop::has($ogCtx, 'type')) {
				$ogCtx['type'] = 'website';
			}

		}
		return $ogCtx;
	}


}
