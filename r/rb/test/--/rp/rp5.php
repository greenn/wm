<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$pBlank = _rp::name('blank');
//dx($pBlank::$cfg, $pBlank::_cfg());

$bBlank = _rb::name('blank');
//dx($bBlank::$cfg, $bBlank::_cfg());

print $pBlank::tpl('blank', array('title' => 'Title P!'));
print $bBlank::tpl('blank', array('title' => 'Title B!'));