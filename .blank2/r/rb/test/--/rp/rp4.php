<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

	$Vue = _rp::name('vue');
	//dx($Vue::$cfg);

	d($Vue::uri('app'));

	//$path = $Vue::path('test/alert.tpl.php');
	//$tpl = $Vue::tpl('test/alert', array('msg' => 111));

	dx(
		rp('vue', 'tpl', 'test/alert', array('msg' => 112)),
		r_tpl('vue', 'test/alert')
	);
