<?#0.0.3

//https://chatgpt.com/c/676145b3-65c0-8008-8c07-b5b886f97303
function mb_basename($path, $suffix = '') {
	$parts = explode('/', $path);
	$basename = end($parts);

	// Удаляем суффикс, если он передан
	if ($suffix && mb_substr($basename, -mb_strlen($suffix)) === $suffix) {
		$basename = mb_substr($basename, 0, -mb_strlen($suffix));
	}

	return $basename;
}