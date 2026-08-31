<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

	$Vue = _rp::name('vue');
	//dx($Vue::$cfg);

	d($Vue::path(array('script.vue.php'), 'tpl.php'));
	d($Vue::path('test/alert-box.vue', 'php'));

	$path = $Vue::path('script.tpl.php');
	$tpl = $Vue::tpl('script', array('a' => 1));
	dx($path, $tpl);
