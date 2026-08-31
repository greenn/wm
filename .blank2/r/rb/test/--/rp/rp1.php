<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

	_rp::need('vue');
	dx(_rp::$db, _rp::$cache, rp_vue::$cfg);