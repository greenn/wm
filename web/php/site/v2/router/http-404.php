<?#4.0.1

$Self = _rb::name('router');
$_ctx = $Self::tempCtx(array(
	'pid' => '',
));
$pid = $_ctx['pid'];

//dx($_ctx);

///$Pid = new pid($pid);
$Self::process('site', array(
	'use-pid' => '404'
));

/*
print site_tpl('page', 'html', array(
	'pageTitle' => 'HTTP 404 Страница не найдена',
	'app' => array(),
	'body' => site_tpl('page', 'page', array(
		'content' => site_tpl('error', '404', array(
			//'uri' => $pid
		))
	))
));*/