<?#4.0.0
$Self = _rb::name('router2');
$_ctx = $Self::tempCtx(array(
	//prepareRootCtx
	'Uri' => false,
	'use-pid' => false,

	'body' => false, //напрямую контент может запустить например другой роутер
	'html-ctx' => array(),
	'page-ctx' => array(),
	'app-ctx' => array(),

	'content-title' => false,
	'page-title' => false,

	//'r-class' => false,
));


list($htmlCtx, $pageCtx, $appCtx, $fullCtx) = rb_router2::prepareRootCtx($_ctx);
//dx($htmlCtx, $pageCtx, $appCtx, $fullCtx);

$rMain = cur_opt('rMain');

if ($_ctx['body'] === false) {
	//case base: body по pid

	//AK $body = site_tpl('page', 'page', $pageCtx);
	$body = _r_tpl_($rMain, 'page', 'page', $pageCtx);
	//$body = gss3_tpl('page', 'page', $pageCtx);
	//dx($body);

} else {
	//case: reuse router for raw -body
	$body = $_ctx['body'];
}

//dx($pageCtx, $body, $htmlCtx, $appCtx);

$rootCtx = array(
	'body' => $body,
	'app' => $appCtx,
	'page' => $htmlCtx, //~> $rbPageCtx
	'metrika' => productionMod
);


print _r_tpl_($rMain, 'page', 'html', $rootCtx);
