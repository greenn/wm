<?#3.0.0

//$Self = _rb::name('router');
$_ctx = rb_router::tempCtx(array(
	'pid' => false,
));

$pid = $_ctx['pid'];
$tplBody = _page($pid, 'body-tpl');


$body = rb('page-content', 'applyContent', $tplBody);
//dx($tplBody, $body);

print site_tpl('page', 'html', array(
	'body' => $body
));