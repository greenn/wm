<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

rt('css/materialize', 'req');

$Root = _rt::name('root');
$Root::req_css($Root::relDir('login/page'));

print rb_tpl('page', 'page', array(
	'pageTitle' => 'login / materialize.css',
	'body' => rt_tpl('root', $Root::relDir('login/page')),
	'webkit' => array(
		'jquery'
	),
	'raw-source' => <<<html
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!--
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
-->
html
	,
));

