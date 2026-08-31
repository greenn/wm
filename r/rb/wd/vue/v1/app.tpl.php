<?
$Self = _rb::self();

rb('page', 'webkit', 'vue-env-2');

//$Self::req_css('app');



$_ctx = $Self::tempCtx(array(
	//dd 'vue' => array(), //array('rName' => '', 'tplName' => '', 'vueName' => '', 'rClass' => ''),
	'content' => array(),
    'opt' => ''
));

$appOpt = $_ctx['opt'];
if ($appOpt) $appOpt = '?'.$appOpt;

$jsFileName = $Self::relDir('app');

$Self::req_js($jsFileName.$appOpt);

$content = $_ctx['content'];


if (false && 'dd') {
	$vueCtx = $_ctx['vue'];
	if ($vueCtx) {
		$content = rb_tpl('vue', 'vue-tag', $vueCtx);
			//>>
				//oo kot/r/test/vue-tag.tpl.php
				list($rName, $tplName, $vueName) = rb('vue', 'align_vue_args', $_ctx['vue'], true);
	}
}


?>
<div id="wd-vue">
	<?=$content?>
</div>
