<?#4.0.0
$Self = _rb::name('router');
$_ctx = $Self::tempCtx(array(
	//prepareRootCtx
	'use-pid' => false,

	'body' => false, //напрямую контент может запустить например другой роутер
	'html-ctx' => array(),
	'page-ctx' => array(),
	'app-ctx' => array(),

	'content-title' => false,
	'page-title' => false,

	'r-class' => false,
));



//d($_ctx);

list($htmlCtx, $pageCtx, $appCtx, $fullCtx) = rb_router::prepareRootCtx($_ctx);
//dx($htmlCtx, $pageCtx, $appCtx, $fullCtx);


$mainR = 'site';
if (_x('hkIqMainR')) $mainR = _x('hkIqMainR');

if ($_ctx['body'] === false) {
	//case base: body по pid

	//AK $body = site_tpl('page', 'page', $pageCtx);
	$body = _r_tpl_($mainR, 'page', 'page', $pageCtx);
	//$body = gss3_tpl('page', 'page', $pageCtx);
	//dx($body);

} else {
	//case: reuse router for raw -body
	$body = $_ctx['body'];
}


//dx($body);

//dx($pageCtx);

//dx($pageCtx, $body, $htmlCtx, $appCtx);

$rootCtx = array(
	'body' => $body,
	'app' => $appCtx,
	'page' => $htmlCtx, //~> $rbPageCtx
	'metrika' => productionMod
);



$rClass = _prop($_ctx, 'r-class');
if (!$rClass) $rClass = $mainR;

print _r_tpl_($rClass, 'page', 'html', $rootCtx);
