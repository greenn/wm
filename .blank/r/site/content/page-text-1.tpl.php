<?
$Self = _site::self();
$nPT1 = $Self::nc('PT1');

$Self::req_css('page-text');
//$Self::req_js('blank');

$_ctx = $Self::tempCtx(array(
    'var' => '',
    'nc' => $nPT1,

	'pic-main-def' => array(
		'tpl' => 'split-3d-1'
	),

));

print lay_tpl('text', 'vmk-text-1', $_ctx);
