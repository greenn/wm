<?#0.2.0

_addphp('file/chmodVal');

function save_file($path = false, $content = '', $chmod_file = false, $chmod_dir = 0777){
	$success = true;
	if (!is_dir($dirPath = dirname($path))) {
		mkdir($dirPath, chmodVal($chmod_dir), true);
	};

	$file = fopen($path, "w");
	if (!empty($content)) {
		$success = fwrite($file, (string) $content);
	}
	fclose($file);
	if ($chmod_file) chmod($path, chmodVal($chmod_file));
	return $success;
}
