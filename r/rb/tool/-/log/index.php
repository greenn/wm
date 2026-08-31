<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
include_once dirname(__FILE__).'/tool-log.class.php';

print rb_tpl('page', 'page', array(
	'pageTitle' => 'Log tool',
	'body' => rw_tpl('tool-log', 'app'),
	'webkit' => array(
		'vue-env',
		'moment',
	),
));