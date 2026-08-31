<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

rt('css/materialize', 'req');
$Root = _rt::name('root');

print rb_tpl('page', 'page', array(
	'pageTitle' => 'checkboxes / materialize.css',
	'body' => rt_tpl('root', $Root::relDir('checkboxes/page')),
	'webkit' => array(
		'jquery'
	),
));

