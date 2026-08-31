<?#0.0.3

//https://chatgpt.com/c/676145b3-65c0-8008-8c07-b5b886f97303
function truerawurlencode($url) {
	$parsedUrl = parse_url($url);

	// Обработка протокола и домена, если они есть
	$scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] . '://' : '';
	$host = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
	$path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
	$query = isset($parsedUrl['query']) ? $parsedUrl['query'] : '';

	// Разделяем путь на части и кодируем каждую часть
	$parts = explode('/', $path);
	foreach ($parts as &$part) {
		if ($part !== '') { // Пропускаем пустые элементы
			$part = rawurlencode($part);
		}
	}

	// Объединяем закодированный путь
	$encodedPath = implode('/', $parts);

	// Обработка query (параметров запроса)
	$encodedQuery = $query ? '?' . rawurlencode($query) : '';

	// Собираем итоговый URL
	$finalUrl = "{$scheme}{$host}{$encodedPath}{$encodedQuery}";
	return $finalUrl;
}