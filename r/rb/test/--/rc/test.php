<?
# _/test/rc/test.php


include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
include_once dirname(__FILE__).'/custom-r.class.php';
//ak _rw::add(dirname(__FILE__).'/custom-r.class.php');

//$R = _rw::name('rc_eg');
//dx($R::_cfg());
//dx(_rw::$db);

print rw_tpl('rc_eg', 'template', array('title' => '= TITLE ='));