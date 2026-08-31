<?#0.3.2

//редирект текущей страницы со сменой параметра

function doRedirectNextPrm($prmData){
	$curUri = URI;
	$parsedUri = parse_url($curUri);

	parse_str($parsedUri['query'] ?? '', $curParams);

	$newParams = array_replace($curParams, $prmData);

	//Сравниваем, изменились ли параметры
	if ($newParams !== $curParams) {
		// Собираем новый query
		$newQuery = http_build_query($newParams);

		// Собираем полный путь (с учётом base path)
		$redirectPath = $parsedUri['path'] . '?' . $newQuery;

		doRedirect($redirectPath);
	}

}

	//za
	function getRedirectNextPrm($prmData){
		$curUri = URI;
		$parsedUri = parse_url($curUri);

		parse_str($parsedUri['query'] ?? '', $curParams);

		$newParams = array_replace($curParams, $prmData);

		$newQuery = http_build_query($newParams);

		return $parsedUri['path'] . '?' . $newQuery;
	}

//редирект текущей страницы со сменой параметра
function doRedirect($url){
	if (!headers_sent()) {
		// Если заголовки ещё не отправлены — используем header
		header("Location: $url", true, 302);
		exit;
	} else {
		// Иначе — через JavaScript
		echo "<script>window.location.href = " . json_encode($url) . ";</script>";
		echo "<noscript><meta http-equiv=\"refresh\" content=\"0;url=" . htmlspecialchars($url) . "\"></noscript>";
		exit;
	}
}