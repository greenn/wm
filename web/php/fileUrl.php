<?#2.0

_needphp('rootLess');


function fileUrl($path = true, $leadingSlash = true, $ROOT = true){
	if ($path === true) {
		$path = php('getCaller', 'path');
	}

	$resPath = str_replace('\\', '/', rootLess($path, false, $ROOT));

	return $leadingSlash ? $resPath : ltrim($resPath, '/');
}
