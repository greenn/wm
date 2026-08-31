<?
$_ctx = rb('router', 'tempPidCtx', array(
	'rName' => true,
	'router-list' => true,
	'mode' => '',
));
$Pid = $_ctx['Pid'];
$pid = $_ctx['pid'];

$rName = $_ctx['rName'];
if ($rName === true) $rName = $pid;
//
//dx($_ctx);

$Self = _site::name($rName);

$routerCtx = array();
$pageCtx = array();

$uriChunks = $Pid->subParts;


if ($uriChunks) {
	$mode = $_ctx['mode']; //ak modMode ('uri', 'def')
	$subPage = array_shift($uriChunks);

	if ($mode === 'uri') {
		$pageData = $Self::getItemByUri($subPage, true);
	} else { //def
		$pageData = $Self::getItem($subPage);
	}

	//dx($mode, $subPage, $pageData);

	if (!$pageData) {

		rb('router', 'process', 'http-404', array());

	} else {

		rb_router::process('page', array(
			'page-ctx' => $pageData['page-ctx'],
			'html-ctx' => $pageData['html-ctx'],
		));
	}

} else {
	//case: titul page

	$listRouter = $_ctx['router-list'];
	if (is_array($listRouter)) {

		rb('router', 'process', $listRouter['router'], $listRouter['router-ctx']);

	} else {

		//dx(11);
		//rb('router', 'process', 'page', array('use-pid' => $pid));
		rb('router', 'process', 'site', array('use-pid' => $pid));

	}



}