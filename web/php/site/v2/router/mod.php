<?#2.2.0
$Self = _rb::name('router2');
$_ctx = $Self::tempCtx(array(
	'subUri' => pageUri,
	'Pid' => null,
	'use-pid' => false,

	'mod-r' => false,
	'titul' => false,
	'list' => false,
	'item' => false,
));

$uri = $_ctx['subUri'];
$Pid = $_ctx['Pid'];

//dx($_ctx, $uri, $Pid, @$Pid->parts);

$modR = $_ctx['mod-r'];
$R = call_user_func("_{$modR[0]}::name", $modR[1]);
//dx($R);

$subCount = count($Pid->subParts);
//dx($Pid, $subCount);

if ($subCount === 0) {

	list($htmlCtx, $pageCtx, $appCtx) = rb_router2::prepareRootCtx($_ctx['titul']);
	dx($_ctx['titul'], $htmlCtx, $pageCtx, $appCtx);

	//$pageCtx['content'] = site_tpl('catalog', 'cats-list', array());



}


list($htmlCtx, $pageCtx, $appCtx, $fullCtx) = rb_router2::prepareRootCtx($_ctx);
//dx($htmlCtx, $pageCtx, $appCtx, $fullCtx);


$rMain = cur_opt('rMain');


//dx($pageCtx);

//AK $body = site_tpl('page', 'page', $pageCtx);
//$body = _r_tpl_($rMain, 'page', 'page', $pageCtx);
$body = gss3_tpl('page', 'page', $pageCtx);
//dx($body);


//dx($pageCtx, $body, $htmlCtx, $appCtx);

$rootCtx = array(
	'body' => $body,
	'app' => $appCtx,
	'page' => $htmlCtx, //~> $rbPageCtx
	'metrika' => productionMod
);

//	dx($pageCtx, $appCtx);
//dx($rootCtx);


///AK print site_tpl('page', 'html', $rootCtx); exit;



///$rClass = _prop($_ctx, 'rClass', $rMain);
print _r_tpl_($rMain, 'page', 'html', $rootCtx);
