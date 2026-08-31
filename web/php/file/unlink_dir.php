<?#0.2.0

function unlink_dir($dirPath){
	if (is_dir($dirPath)) {
		$dirPath = rtrim($dirPath, '/\\').DS;
		$list = glob($dirPath . '*', GLOB_MARK);
		//dx(func_get_arg(0), $dirPath, $list);
		foreach ($list as $path) {
			if (is_dir($path)) {
				unlink_dir($path);
			} else {
				unlink($path);
			}
		}

		rmdir($dirPath);
	}


	return !is_dir($dirPath);
}

/* Без-суб директорий
    array_map('unlink', glob("$dir/*.*"));
    if (count(glob("$dir/*")) === 0)) rmdir($dirPath);
*/