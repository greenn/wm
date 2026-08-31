<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
//include_once ROOT.'/iq/php/source.class.php';

_needphp(
	'qtpl.class'
);

//qtpl(WEB.'/tpl/frame-list');

qtpl_set(array(dirname(__FILE__), 'user'), 'tpl.php');


print _qtpl('frame-list', array(
	'domain' => true,
	'list' => array(
		array('uri' => '/api/user/', 'title' => true),
		//array('', 'live', true),
		array('/api/', 'login', '/api/user/login?user=pew&pass=kkk'),
		array('/api/', 'logout', '/api/user/logout'),
	)
));

