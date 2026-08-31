<?#1.2.0
$Self = _rb::self();

rb('page', 'webkit', 'vue-env-2');

$Self::req_js(3, $Self::relDir('app'));

$_ctx = $Self::tempCtx(array(
	'content' => array(),
));

$content = $_ctx['content'];

?>
<div id="wd-vue-3">
	<?=$content?>
</div>
