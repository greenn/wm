<?#0.2.2

_addphp('file/unlink_dir');
_addphp('file/isSubFolder');
/*
    $existSol
		skip - не копировать
		rename - переименовать
		rewrite - заменить директорию
		merge - переписать файлы
		add - добавьб недостающие
*/

define('MOVE_DIR__EXIST_SKIP', 0);
define('MOVE_DIR__EXIST_REWRITE', 1);
define('MOVE_DIR__EXIST_RENAME', 2);
define('MOVE_DIR__EXIST_RENAME_PREV', 3);
//define('MOVE_DIR__EXIST_MERGE', 3);
//define('MOVE_DIR__EXIST_ADD', 4);


function move_dir($srcPath, $destPath, $depth = 0, $existSol = MOVE_DIR__EXIST_RENAME) {

	if (is_dir($destPath)) {
		switch ($existSol) {
			case MOVE_DIR__EXIST_RENAME: {
				$destPath = unique_dirpath($destPath);
			} break;
			case MOVE_DIR__EXIST_REWRITE: {
				unlink_dir($destPath);
			} break;
			case MOVE_DIR__EXIST_RENAME_PREV: {
				$newDestPath = unique_dirpath($destPath);
				move_dir($destPath, $newDestPath);
			} break;
			//case MOVE_DIR__EXIST_MERGE: {} break;
			//case MOVE_DIR__EXIST_ADD: {} break;
			case MOVE_DIR__EXIST_SKIP: default: {
				return false;
			} break;
		}
	}

	if (isSubFolder($srcPath, $destPath)) {
		//case: перенос директории внутрь себя
		//sol: переносим во временную директорию, иначе происходит ошибка (code 32)
		$tmpDir = $srcPath.'.PHP_MOVE['.microtime(true).']';
		move_dir($srcPath, $tmpDir);
		$srcPath = $tmpDir;
		//dx($srcPath, $tmpDir, $destPath);
	}

	$parentDir = dirname($destPath);
	if (!is_dir($parentDir)) {
		mkdir($parentDir, 0777, true); //0777
	}


	//d($srcPath, $destPath);
	return rename($srcPath, $destPath);
}
