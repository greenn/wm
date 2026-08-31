<?#4.0.3

//$Self = _rb::name('router');
$_ctx = rb_router::tempCtx(array(
	//prepareRootCtx
	'use-pid' => false,
	'html-ctx' => array(),
	'page-ctx' => array(),
	'app-ctx' => array(),

	'content' => false, //напрямую контент может запустить например другой роутер
	'content-title' => false,
	'page-title' => false,
));

//расфасовываем контексты
list($htmlCtx, $pageCtx, $appCtx) = rb_router::prepareRootCtx($_ctx);
//d($htmlCtx, $pageCtx, $appCtx);

_rb::req('page-content');
//собираем полный content-ctx
$tplCtx = rb_page_content::handleContentsCtx($pageCtx);
//dx($tplCtx);

$content = rb_page_content::applyContentsCtx($tplCtx);
//dx($tplCtx, $content);

print site_tpl('page', 'html', array(
	'page' => $htmlCtx, //> $rbPageCtx
	'app' => $appCtx,
	'body' => $content,
));