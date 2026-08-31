<?
$Self = _lay::self();

$_ctx = $Self::tempCtx(array(
	'content' => '',
	'opts' => array(),
));
$opts = $_ctx['opts'];

$content = $_ctx['content'];
$content = LayTextParser::parseText($content);

?>
<p>
	<?=$content?>
</p>