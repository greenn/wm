<?
// site/rp/__/test/custom.php
	// site/rp/__/test/mb.php?custom
include_once $_SERVER['DOCUMENT_ROOT'].'/site/iq.inc';


$Self = self_rp();

ob_start(); ?>

	<style type="text/css">

	</style>

<?=$Self::tpl('blank')?>


<? $body = ob_get_clean();

print rp_tpl('page', 'page', array(
	'body' => $body,
    //'webKit' => true,
));