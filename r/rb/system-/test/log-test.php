<?
// site/rp/__/test/custom.php
	// site/rp/__/test/mb.php?custom
include_once $_SERVER['DOCUMENT_ROOT'].'/site/iq.inc';

_log(11);

$Self = self_rp();

print rp_tpl('page', 'page', array(
	'body' => $Self::tpl('blank'),
    //'webKit' => true,
));