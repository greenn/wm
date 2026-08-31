<?#0.2.0
_addphp('file/save_file');

function create_file($path = false, $chmod_file = false, $chmod_dir = 0777){
	if (!is_file($path)) {
		save_file($path, '', $chmod_file, $chmod_dir);
	}
}