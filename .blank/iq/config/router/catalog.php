<?
$_ctx = rb('router', 'tempCtx', array(
	'Pid' => false,
	'pid' => 'catalog',
	'subUri' => pageUri,
));
$pid = $_ctx['pid'];
$uri = $_ctx['subUri'];
$Pid = new pid("$pid/$uri"); //объект обёртка вокруг url

$Self = _site::name('catalog');
//graveyard
//pamyatniki


//if (!isLocalhost) {
	//print 'Обновление…'; exit;
//}

//if (!isLocalhost) $Self::req_js(1, 'blank'); //fake broke

$overlap = !isLocalhost;
//$overlap = true;
$overlap = false;

if ($overlap) {
	rb('router', 'process', 'plain', array('pid' => 'upd'));
	exit;
}

$uriChunks = $Pid->subParts;
$sectionName = array_shift($uriChunks);

if ($sectionName) {

	$tplName = site('catalog', 'getTplHandler', $sectionName);
	$pageName = array_shift($uriChunks);


	if ($pageName) {

		//$itemPageCtx = $Self::itemPageCtx($sectionName, $pageName);
		$itemPageCtx = site_catalog::itemPageCtx($sectionName, $pageName);
		//dx($itemPageCtx);
		rb_router::process('site', $itemPageCtx);

	} else {

		$sectionPageCtx = $Self::sectionPageCtx($sectionName);
		//dx($sectionPageCtx);
		rb_router::process('site', $sectionPageCtx);

	}

} else {

	//$titulData = $Self::getTitulData($sectionName);

	$pid = 'catalog';
	set_cur_pid($pid);
	$pageCtx = array('use-pid' => $pid) + $Self::pageCtxDef();
	//d($pageCtx);

	rb('router', 'process', 'site', $pageCtx);

}