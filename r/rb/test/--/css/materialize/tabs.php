<?
/*
	https://materializecss.com/tabs.html
*/
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
rt('css/materialize', 'req');

$Root = _rt::name('root');

print rb_tpl('page', 'page', array(
	'pageTitle' => 'select / materialize.css',
	//'body' => rt_tpl('root', 'iq/test/css/materialize/select/page'),
	'body' => rt_tpl('root', $Root::relDir('tabs/page')),
	'webkit' => array(
		'jquery'
	),
));

