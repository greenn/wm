<?

//$Router = _rb::name('router');
//$_ctx = $Router::tempCtx(array(
$_ctx = rb('router', 'tempCtx', array(
	'Pid' => false,
	'pid' => 'post',
	'subUri' => pageUri,
));

//case base
$Pid = $_ctx['Pid']; //через applyHandlerByUri

//case custom
$pid = $_ctx['pid'];
$uri = $_ctx['subUri'];
if (!$Pid) {
	$Pid = new pid("$pid/$uri");
}

//
$Self = _site::name('company');


$uriChunks = $Pid->subParts;
dx($uriChunks, pageUri);

$subName = array_shift($uriChunks);
$tplName = site('catalog', 'getTplHandler', $subName);
//dx($subName, $tplName);

$content = site_tpl('post', $tplName, array(
	'uri' => join('/', $uriChunks)
));

//$Self
rb_router::process('page', array(
	'content' => $content
));
//print rb('router', 'process', 'catalog', array());