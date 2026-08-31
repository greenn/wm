<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
include_once dirname(__FILE__).'/tool-log.class.php';
_needphp('log');


_api::addRoute('log', array('rw', 'tool-log'));
//dx(rt_api::request('tool-log/test', array(), 'GET', 'rw'), rt_api::request_info());
//dx(_api::log('cur', array('tmp' => strtotime('-1 hours'))));
//dx(_api::log('test'));
//dx(_api::get('user/test'));


$logData = log::getData();
//_log('тестовый запрос', s::incr('a'));
//1648209082 '1648157577.7002'

dx(
	//$tm = strtotime('-60 minutes'),
	$tm = strtotime('-4 hours'),
	log::dataFilter($logData, 'log', $tm)
);
