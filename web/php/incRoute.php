<?

//4

//позволять вставить handler другого пути
function incRoute($routePath){

	if (is_string($routePath)) {

		$inspectedSubPath = php('getCaller', 'dir').'/'.ltrim($routePath, '/');
		if (is_dir($inspectedSubPath)) {
			$inspectedSubPath = rtrim($inspectedSubPath, '/').'/'.'index.php';
		}
		if (is_file($inspectedSubPath)) {
			include $inspectedSubPath;

		} else {

			$inspectedPath = ROOTs.ltrim($routePath, '/');
			if (is_dir($inspectedPath)) {
				$inspectedPath = rtrim($inspectedPath, '/').'/'.'index.php';
			}
			if (is_file($inspectedPath)) {
				include $inspectedPath;
			}

		}
	}

}


/*
	throw error
*/