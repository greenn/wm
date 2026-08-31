<?#2.3.1
$Self = _rb::name('router');
$_ctx = $Self::tempCtx(array(
	//'pid' => '', //L
	'use-pid' => false,

	'html-ctx' => array(),
	'page-ctx' => array(),
	'app-ctx' => array(),

	'content' => false, //напрямую контент может запустить например другой роутер
	'content-title' => false,
	'page-title' => false,
));

$pid = $_ctx['use-pid'];

//dx($pid, $_ctx);

if ($pid) {
	$pageData = _page($pid);

	$htmlCtx = _prop($pageData, 'html-ctx', array());
	$pageCtx = _prop($pageData, 'page-ctx', array());
	$appCtx =  _prop($pageData, 'app-ctx', array());

	//dx($pid, $pageData);

	rb_router::_collectContentCtx($pageData, $pageCtx);

	$contentTitle = _prop::pikIn($pageData, 'title', array('content', '-page'));

	$pageTitle = _prop::pikIn($pageData, 'title', array('page', 'content'));
	//$pageTitle = _page::pageTitle(array($pageTitle, $modTitle));
	$pageTitle = _page::pageTitle($pageTitle);

} else {

	$htmlCtx = $_ctx['html-ctx'];
	$pageCtx = $_ctx['page-ctx'];
	$appCtx = $_ctx['app-ctx'];

	$contentTitle = $_ctx['content-title'];
	$pageTitle = $_ctx['page-title'];

	$content = $_ctx['content'];
	if ($content) {
		$pageCtx['content'] = $content;
	}

}

$pageCtx['content-title'] = $contentTitle;
$htmlCtx['pageTitle'] = $pageTitle;


//dx($pageCtx);

$rootCtx = array(
	'body' => site_tpl('page', 'page', $pageCtx),
	'app' => $appCtx,
	'page' => $htmlCtx,
);

//	dx($pageCtx, $appCtx);
print site_tpl('page', 'html', $rootCtx);