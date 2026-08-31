<?
$Self = _rb::self();
$_ctx = $Self::tempCtx(array(
	'list' => array(),
	'header' => true,
));
$list = $_ctx['list'];
$useHeader = $_ctx['header'];


$regex_non_ascii = '~[^[:ascii:]]+~';

$rn = "\r\n";
$tb = "\t";

$masking_symbols = array(
	'&' => '&amp;',
	'\'' => '&apos;',
	'"' => '&quot;',
	'>' => '&gt;',
	'<' => '&lt;'
);


$xml = array();

$xml []= '<?xml version="1.0" encoding="UTF-8"?>';
//$xml []= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
$xml []= sprintf('<urlset %s>', join(' ', array(
	# Для проверки Вашего файла Sitemap или файла индекса Sitemap по схеме
	# в XML-файл нужно добавить дополнительные заголовки, как показано ниже.
	'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"',
	'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"',

	'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"',

	# Протокол Sitemap можно расширить с помощью Вашего собственного пространства имен
	//'xmlns:example="http://www.example.com/schemas/example_schema"', # https://www.sitemaps.org/ru/protocol.html#extending
)));

$showLastmod = true;
$setPriority = true;
$noteChangefreq = true;


foreach ($list as $pagePath => $set) {
	$conf = array();
	if (!is_array($set)) {
		if (!$set) continue;
	} else if (isOrdinal($set)) {
		//case: $set is {ao}
		$rule = array('priority', 'changefreq', 'lastmod');
		$maxIndex = count($rule) - 1;
		foreach ($set as $index => $value) {
			if ($index <= $maxIndex) {
				$conf[$rule[$index]] = $value;
			}

		}
	} else {
		$conf = $set;
	}

	$props = array();

	$domainUrl = $Self::domainUrl(true);
	# loc
	$pathParts = explode('/', trim($pagePath, '/'));
	foreach ($pathParts as &$pathPart) {
		$pathPart = preg_replace_callback($regex_non_ascii, 'rb_sitemap::cb_encode_non_ascii', $pathPart);
		$pathPart = strtr($pathPart, $masking_symbols);
	}

	$loc = sprintf("%s%s", $domainUrl, join('/', $pathParts));
	if (false && 'страницы в sitemap с закрывающим слешем') {
		$loc = rtrim($loc, '/').'/';
	} else {
		$loc = rtrim($loc, '/');
		if ($pagePath === '/') {
			$loc .= '/'; //для титульной всё равно добавляем закрывающий слеш
		}
	}
	//dx($loc, $domainUrl, $pathParts, $pagePath);

	$props []= sprintf("$tb$tb<loc>%s</loc>", $loc);

	# lastmod
	$timestamp = null;
	if (isset($conf['pagePath']) && is_file($conf['pagePath'])) {
		$timestamp = filemtime($conf['pagePath']);
	} elseif (isset($conf['structPath']) && $conf['structPath']) {
		$timestamp = filemtime($conf['structPath']);
		//dx($timestamp);
	} elseif (isset($conf['timestamp'])) {
		$timestamp = $conf['timestamp'];
	}
	$timestamp = $timestamp ?: time();
	$lastmod = date(DateTime::W3C, $timestamp);
	//qe прямой 'lastmod'
	$props []= sprintf("$tb$tb<lastmod>%s</lastmod>", $lastmod);

	# priority
	$priority = isset($conf['priority'])? $conf['priority'] : '0.1';
	$props []= sprintf("$tb$tb<priority>%s</priority>", $priority);

	# changefreq
	//hourly, daily, weekly, monthly, yearly
	$changefreq = isset($conf['changefreq'])? $conf['changefreq'] : 'daily';
	$props []= sprintf("$tb$tb<changefreq>%s</changefreq>", $changefreq);

	$xml []= sprintf("$tb<url>$rn%s$rn$tb</url>", join($rn, $props));

}


$xml []= '</urlset>';

if(1) if ($useHeader) {
	header('Content-type: text/xml');
	//headers('xml', 'utf8', 'nosniff');
}
print join($rn, $xml);
