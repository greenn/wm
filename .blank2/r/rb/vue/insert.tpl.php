<?

$Self = _rb::self();
$_ctx = $Self::tempCtx(array(
	'name' => false,
	'attrs' => '', //
	'attr' => array(),
));
$tag = $_ctx['name'];
if (!$tag) $tag = prop($_ctx, 'id', 'vue');

$attrs = (array)$_ctx['attrs'];

$attr = $_ctx['attr'];
if (is_array($attr)) {
	foreach ($attr as $prop => $value) {
		$attrs []= "$prop=\"$value\"";
	}
} else if (is_string($attr)) {
	$attrs []= $attr;
}

$attrs = join(' ', $attrs);
?>
<<?=$tag?> <?=$attrs?>></<?=$tag?>>