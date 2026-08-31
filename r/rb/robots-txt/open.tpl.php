<?#1.3.0
$Self = _rb::self();
$_ctx = $Self::tempCtx(array(
	'header' => true,
	'sitemap' => 'sitemap.xml',
));
$sitemap = $_ctx['sitemap'];

$useHeader = $_ctx['header'];
if ($useHeader) {
	//header('Content-type: text/xml');
	headers('txt', 'utf8', 'nosniff');
}

$domainUrl = $Self::domainUrl(false);
?>
<?//# Открываем доступ всем роботам ко всему сайту?>
User-agent: *
Allow: /
<? if ($sitemap) { ?>
    Sitemap: <?=$domainUrl?>/<?=$sitemap?>
<? } ?>
