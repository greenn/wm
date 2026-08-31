<?
// site/rp/grid/test/grid.php
	// site/rp/grid/test/mb.php?grid
include_once $_SERVER['DOCUMENT_ROOT'].'/site/iq.inc';

$Self = self_rp();

$name = gt('name');

if ($grid = gt('grid')) {
	$name = "grid/$grid";
}

$path = $Self::path($name, 'tpl.css.php');
if (!is_file($path)) {
	dx(is_file($path), $path);
}

$tplCtx = array(
	'np' => 'PARENT',
	'mq_' => array(MQ2, MQ3),
	'sh_' => array('100px', '100%', '100vw'),
	'sv_' => array(30, 20, 10),
);

if ($grid) {}


headers('css', 'utf8', 'nosniff', etag::ctx(
	pcss_etag_ctx('transition'),
	etag::extra(
		$name
	),
	$path,
	__FILE__
), SITE_CACHE);

print $Self::cssTpl($name, $tplCtx);
