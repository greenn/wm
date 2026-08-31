<?
$Self = site_rp('page');

extract($Self::tplCtx(array(
	'logExport' => true,
))); $logExport;

//here: прогружены все составляющие страницы
$css = site_css::export();
$js = site_js::export();

if ($logExport) {
	$Self::log('export', array( //body|export|
		'css' => $css,
		'js' => $js,
	));
    //dx($Self::get_log('export'), $Self::$log);
}

?>
<script type="text/javascript">
	<?= $css['jsData']?>
	<?= $js['jsData']?>
</script>