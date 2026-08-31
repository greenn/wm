<?
$Self = _lay::self();

$_ctx = $Self::tempCtx(array(
	'nc' => '',
));

$nc = $_ctx['nc'];
if (!$nc) {
	$nc = $Self::nc('Bk1'); //
	$Self::req_css('blank-1');
}

?>
<div class="<?=$nc?>">
    <i><?=$Self::cfg('className')?></i>
</div>