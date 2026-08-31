<?#0.2.1
_addphp('file/chmodVal');

function ensureDir($dirPath, $chmod = true){
	if (!is_dir($dirPath)) {
		mkdir($dirPath, chmodVal($chmod, 0777), true);
	}
	return $dirPath;
}

function ensureFileDir($filePath, $chmod = true){
	return ensureDir(dirname($filePath), $chmod);
}