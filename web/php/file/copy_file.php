<?#0.3.1

_addphp('file/unique_path');
_needphp('x.class/_x');

define('COPY_FILE__EXIST_SKIP', 0);
define('COPY_FILE__EXIST_REWRITE', 1);
define('COPY_FILE__EXIST_RENAME', 2);
define('COPY_FILE__EXIST_RENAME_PREV', 3);


function copy_file($srcPath, $destPath = true, $existSol = COPY_FILE__EXIST_SKIP){
	_x('php/copy_file', array());
	if (!is_file($srcPath)) return null;

	if ($destPath === true) {
		$destPath = unique_path($srcPath);
	}

	//$newDestPath = false;
	if (is_file($destPath)) {
		switch ($existSol) {
			case COPY_FILE__EXIST_REWRITE: {
				//continue;
			} break;
			case COPY_FILE__EXIST_RENAME: {
				$destPath = unique_path($destPath);
				_x('php/copy_file', array('exist-rename' => $destPath));
			} break;
			case COPY_FILE__EXIST_RENAME_PREV: {
				$prevNewDest = unique_path($destPath);
				rename($destPath, $prevNewDest);
				_x('php/copy_file', array('exist-rename-prev' => $prevNewDest));
				//continue;
			} break;
			case COPY_FILE__EXIST_SKIP: default: {
				return false; //true
			}
		}
	}

	//if ($newDestPath) $destPath = $newDestPath;
	$destDir = dirname($destPath);
	
	if (!is_dir($destDir)) {
		mkdir($destDir, 0755, true);
	}

	copy($srcPath, $destPath);

	return $destPath;
}