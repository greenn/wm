<?
// site/rp/grid/test/grid.php
	// site/rp/grid/test/mb.php?grid
include_once $_SERVER['DOCUMENT_ROOT'].'/site/iq.inc';


$Self = self_rp();
$Self::req_css('preset');

ob_start(); ?>

	<style type="text/css">

	</style>

<?=$Self::tpl('grid', array(
	'dbg' => true,
    'items' => range(1, 10),
	'sz' => gt('sz', 1),
	'cols' => gt('cols', 2),
	'mq' => gt('mq', 'site'),
))?>


<? $body = ob_get_clean();

print rp_tpl('page', 'page', array(
	'body' => $body,
    //'webKit' => true,
));