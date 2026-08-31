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

$domainUrl = $Self::domainUrl(false);
?>
<?//# Открываем доступ всем роботам ко всему сайту?>
User-agent: *
Disallow:

Sitemap: <?=$domainUrl?>/sitemap.xml
