<?//1.16.2
//[o]

//_needphp('str/l/urlFilename');


function fileVarName($path = false, $trimExtension = true){
	if (!$path) {
		$path = php('getCaller', 'path');
	}

	$path = rootLess($path);

	if ($trimExtension) {
		$ext = $trimExtension === true ? pathinfo($path, PATHINFO_EXTENSION) : $trimExtension;
		$path = pathinfo($path, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . basename($path, '.' . $ext);
	}

	return preg_replace(
		array(
			'~[^_\p{L}\p{N}]~',
		),
		array(
			'_',
		),
		$path
	);
}

