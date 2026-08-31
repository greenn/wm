<?#0.1.1


/*
    $existSol
		skip - не копировать
		rename - переименовать
		rewrite - заменить директорию
		merge - переписать файлы
		add - добавьб недостающие
*/
define('COPY_DIR__EXIST_SKIP', 0);
define('COPY_DIR__EXIST_RENAME', 1);
define('COPY_DIR__EXIST_REWRITE', 2);
define('COPY_DIR__EXIST_MERGE', 3);
define('COPY_DIR__EXIST_ADD', 4);
define('COPY_DIR__EXIST_RENAME_PREV', 5);


function copy_dir($srcPath, $destPath, $depth = 0, $existSol = COPY_DIR__EXIST_SKIP) {

	if (is_dir($srcPath)) {
		if (is_string())

		switch ($existSol) {
			//case COPY_DIR__EXIST_RENAME: {} break;
			//case COPY_DIR__EXIST_REWRITE: {} break;
			//case COPY_DIR__EXIST_RENAME_PREV: {} break;
			//case COPY_DIR__EXIST_MERGE: {} break;
			//case COPY_DIR__EXIST_ADD: {} break;
			case COPY_DIR__EXIST_SKIP: default: {
				return;
			}
		}
	}

	$fileList = glob(realpath($srcPath).($depth < 0 ? /*case: только себя, без  содержимого*/'' : '/*'), GLOB_MARK);
	while ($depth >= 0) {}



}
