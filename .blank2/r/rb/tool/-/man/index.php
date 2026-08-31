<?
/*
	просмотр (чтение) man файло
		чтение man-code

	eg
		iq/man/ql
*/
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
include_once $_SERVER['DOCUMENT_ROOT'].'/iq/tool/man/tool-man.class.php';

print rb_tpl('page', 'page', array(
	'pageTitle' => 'Man Reader',
	'body' => rw_tpl('tool-man', 'reader', array()),
	'webkit' => array(
		'vue-env'
	),
));