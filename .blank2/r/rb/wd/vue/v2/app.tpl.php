<?
$Self = _rb::self();

rb('page', 'webkit', 'vue-env-2');

$Self::req_js(2, $Self::relDir('app'));

$_ctx = $Self::tempCtx(array(
	//dd 'vue' => array(), //array('rName' => '', 'tplName' => '', 'vueName' => '', 'rClass' => ''),
	'content' => array(),
    'app-type' => ''
));

$type = $_ctx['app-type'];
$content = $_ctx['content'];


?>
<div id="wd-vue-2">
	<?=$content?>
</div>
