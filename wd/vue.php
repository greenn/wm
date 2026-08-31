<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';

$body;
print kot_tpl('test', 'page', array(
	'body' => $body,
));
