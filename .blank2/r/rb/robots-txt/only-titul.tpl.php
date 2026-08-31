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
<?/*
    разрешает доступ только к главной странице (/).
    Символ $ указывает, что правило применяется только к URL, заканчивающемуся на /.
*/?>
User-agent: *
Disallow: /
Allow: /$

Sitemap: <?=$domainUrl?>/sitemap.xml
