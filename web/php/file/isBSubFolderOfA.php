<?#0.2.1

function isSubFolder($subDir, $parentDir){
	$subDir = rtrim($subDir, '\\/').'/';
	return mb_strpos($parentDir, $subDir) === 0;
}
