<?
$Self = _rb::self();
$_ctx = $Self::tempCtx(array(
	'header' => true,
));
$useHeader = $_ctx['header'];
if ($useHeader) {
	//header('Content-type: text/xml');
	headers('txt', 'utf8', 'nosniff');
}
?>
User-agent: *
Disallow: /
#