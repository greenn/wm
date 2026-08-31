<?#2.0.2

//oo https://www.php.net/manual/en/function.tempnam.php

function unique_path($src, $suffixPattern = '[%s]'){
	if (is_file($src)) return unique_filepath($src, false, $suffixPattern);
	if (is_dir($src)) return unique_dirpath($src, $suffixPattern);
	return $src;
}

//ts web/test/web/php/file/unique_path.php
/*
    $ext - явное указание на расширение, eg если оно двойное .css.php
*/
function unique_filepath($src, $ext = false, $suffixPattern = '[%s]' /*(%)¦[%]¦_%¦-%*/){
	$path = $src;
	if ($dir = realpath(dirname($path))) {
		$ext = is_string($ext) ? $ext : pathinfo($path, PATHINFO_EXTENSION);
		$name = $ext ? basename($path, ".$ext") : basename($path);
		$index = 0;
		do {
			$suffix = ++$index ? sprintf($suffixPattern, $index) : '';
			$path = $dir.DS.$name.$suffix.($ext ? ".$ext" : '');
		} while (is_file($path));
	}
	return $path;
}

function unique_dirpath($src, $suffixPattern = '[%s]'){
	$path = $src;
	if ($dir = realpath(dirname($path))) {
		$name = basename($path);
		$index = 0;
		do {
			$suffix = ++$index ? sprintf($suffixPattern, $index) : '';
			$path = $dir.DS.$name.$suffix;
		} while (realpath($path));
	}
	return $path;
}
