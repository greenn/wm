<?

$Self = _rb::self();
$_ctx = $Self::tempCtx(array(
	'name' => '_App',
	'ctx' => '{}',
));
$name = $_ctx['name'];
$ctx = $_ctx['ctx'];
if (is_array($ctx)) {
	$ctx = jsonPrettyEncode($ctx);
}
?>
const <?=$name?> = Vue.createApp(<?=$ctx?>);