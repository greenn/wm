<?#2.2.0
//pb rb

_addphp('file/unique_path');
_needphp('x.class/_x');


define('MOVE_FILE__EXIST_SKIP', 0);
define('MOVE_FILE__EXIST_REWRITE', 1);
define('MOVE_FILE__EXIST_RENAME', 2);
define('MOVE_FILE__EXIST_RENAME_PREV', 3);


function move_file($srcPath, $destPath, $existSol = MOVE_FILE__EXIST_SKIP){
	_x('php/move_file', array());
	if (!is_file($srcPath)) return null;

	//$newDestPath = false;
	if (is_file($destPath)) {
		switch ($existSol) {
			case MOVE_FILE__EXIST_REWRITE: {
				//continue;
			} break;
			case MOVE_FILE__EXIST_RENAME: {
				$destPath = unique_path($destPath);
				_x('php/move_file', array('exist-rename' => $destPath));
			} break;
			case MOVE_FILE__EXIST_RENAME_PREV: {
				$prevNewDest = unique_path($destPath);
				rename($destPath, $prevNewDest);
				_x('php/move_file', array('exist-rename-prev' => $prevNewDest));
				//continue;
			} break;
			case MOVE_FILE__EXIST_SKIP: default: {
				return false; //true
			}
		}
	}

	//if ($newDestPath) $destPath = $newDestPath;
	$destDir = dirname($destPath);

	if (!is_dir($destDir)) {
		mkdir($destDir, 0755, true);
	}

	$result = rename($srcPath, $destPath);

	return $result;
}


#1.2.1
function move_file_v1($pathFile, $pathDest, $asNewName = false, $rewriteExist = false){

	$pathMoveDir = $asNewName ? dirname($pathDest) : $pathDest;

	if (!is_dir($pathMoveDir)) {
		mkdir($pathMoveDir, 0755, true);
	}

	$pathNewFile = $asNewName ? $pathDest : "$pathMoveDir/".basename($pathFile);

	if (!$rewriteExist) {
		//генерим уникальное имя с префиксом
			//_needphp('file/unique_path'); //- rbv unique_path
			//$pathNewFile = newFileName($pathMoveDir, basename($pathNewFile));
		$pathNewFile = unique_path($pathNewFile);
	}

	$r = is_file($pathFile) && rename($pathFile, $pathNewFile);

	return $r;
}