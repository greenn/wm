<?
$Self = _rb::self();
$_ctx = $Self::tempCtx(array(
	'var' => 'App',
	'id' => 'app',
));
$id = $_ctx['id'];
$var = $_ctx['var'];
?>
<?=$var?>.mount('#<?=$id?>');