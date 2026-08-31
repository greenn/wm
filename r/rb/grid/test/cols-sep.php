<?
// site/rp/grid/test/cols-sep.php
	// site/rp/grid/test/mb.php?mb=cols-sep
include_once $_SERVER['DOCUMENT_ROOT'].'/site/iq.inc';


$Self = self_rp();

//$Self::req_css('grid');

site_js::req_name('jquery');
$Self::req_js('test/cols-sep');

$nG = $Self::nc();

$q = gt('cols', 5);
$total = gt('total', $q * 2 + ($q - 1));
$s = gt('s', 40);
$s_ = css_dec($s, 'S1');
$sz = 'custom';

//dx($q, $s, $s_);

$contentList = range(1, $total);

$cols_css = $Self::cssTpl('grid-cols', array(
	'np' => $nG.'[cols="'.$q.'"]',
    'cols' => $q
));
$sz_css = $Self::cssTpl('grid-sz_', array(
	'np' => $nG.'[sz="'.$sz.'"][cols="'.$q.'"]',
	'cols' => $q,
	'mq_' => array(MQ2, MQ3),
	's_' => $s_,
));

ob_start(); ?>

	<style type="text/css">
        <?=$cols_css?>
        <?=$sz_css?>
	</style>

<?=$Self::tpl('grid', array(
	'dbg' => !gt_on('off'),
    'items' => $contentList,
	'sz' => $sz,
	'cols' => $q,
	'mq' => 'test',
))?>

<? $body = ob_get_clean();

print rp_tpl('page', 'page', array(
	'body' => $body,
    //'webKit' => true,
));