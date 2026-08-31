<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
//$M = _rt::name('css/materialize');
//$M = _rt::name('api');
//dx($M, _rt::$cache);
//dx($M::uri());


//rt('css/materialize', 'req_css', array('1.0.0/css/materialize.min.css'));
//_rt::req_css('css/materialize', array('1.0.0/css/materialize.min.css'));
//css::req(false, '/css/materialize/1.0.0/css/materialize.min.css');
rt('css/materialize', 'req');

$Root = _rt::name('root');

print rb_tpl('page', 'page', array(
	'pageTitle' => 'select / materialize.css',
	//'body' => rt_tpl('root', 'iq/test/css/materialize/select/page'),
	'body' => rt_tpl('root', $Root::relDir('select/page')),
	'webkit' => array(
		'jquery'
	),
));

