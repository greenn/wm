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

$domainHost = rb_robotstxt::domainUrl(false, false);
$domainUrl = rb_robotstxt::domainUrl(false);
?>
<?/*
    Host: $domainHost — указывает Яндексу основной домен для индексации.
    Это помогает поисковой системе правильно отображать домен в результатах поиска.
*/?>
User-agent: *
Disallow: /
Host: <?=$domainHost?>

Sitemap: <?=$domainUrl?>/sitemap.xml
