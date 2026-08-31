<?#3.0.1
$Self = _rb::name('router');
$_ctx = $Self::tempCtx(array(
	//prepareRootCtx
	'use-pid' => false,
	'html-ctx' => array(),
	'page-ctx' => array(),
	'app-ctx' => array(),

	'content' => false, //напрямую контент может запустить например другой роутер
	'content-title' => false,
	'page-title' => false,
));

//$rbPageCtx, $tplCtx, $appCtx
list($htmlCtx, $pageCtx, $appCtx) = rb_router::prepareRootCtx($_ctx);
//dx($htmlCtx, $pageCtx, $appCtx);

if (0) {
	//'body' => site_tpl('page', 'page', $pageCtx),
}

if (0) {
	//site_set('page', 'vtpl', true);
	$tplV = gtv('v', 2, 2);
	$body = site_tplvi('page', 'page', $tplV, $pageCtx);
}

//dx($pageCtx);

$body = site_tpl('page', 'page', $pageCtx);
//dx($pageCtx, $body, $htmlCtx, $appCtx);

$rootCtx = array(

	'body' => $body,
	'app' => $appCtx,
	'page' => $htmlCtx, //> $rbPageCtx
	'metrika' => productionMod
);

//	dx($pageCtx, $appCtx);
print site_tpl('page', 'html', $rootCtx);