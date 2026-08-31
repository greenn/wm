<?
//$Self = _rb::name('router');
//$_ctx = $Self::tempCtx(array('Pid' => false ));

$_ctx = rb('router', 'tempPidCtx', array(), 'lk');
$Pid = $_ctx['Pid'];
$pid = $_ctx['pid'];
$uriChunks = $Pid->subParts;
$pageName = array_shift($uriChunks);

//dx($_ctx, $Pid, $pid, $uriChunks, $pageName);

$tplName = 'acc';

$contentWrapper = array();
$contentWrapper['breadcrumbs'] = 'lk';

if ($pageName) {

	if ($pageName === 'login') {
		$tplName = 'login';
		$contentWrapper['content-title'] = false;

	}
} else {
	$contentWrapper['breadcrumbs'] = 'index';

}

$content = site_tpl('lk', $tplName);
//dx($content);

rb_router::process('site', array(
	'page-ctx' => array(
		'content' => $content,
		'content-title' => page($pid, 'title', 'content'),
		'content-wrapper' => $contentWrapper,
		'footer-v' => 3,
	)
));