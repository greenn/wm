<?
$Self = _lay::self();

$_ctx = $Self::tempCtx(array(
	'nc' => '',
	'content1' => '',
	'content2' => '',
));

$nc = $_ctx['nc'];
$C1 = $_ctx['content1'];
$C2 = $_ctx['content2'];
?>
<div fxr class="<?=$nc?>">
	<div fg><?=$C1?></div>
	<div><?=$C2?></div>
</div>