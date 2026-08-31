<? #1i

function dir_access(){}


// проверка на вызов из данной директории

	//if (path_inside(true, $path)) {}
	//if (dir_inside($path, true)) {}

	_needphp('str');
	function path_inside($path, $accessPath = false){


		$pathStart = null;

		if ($accessPath === true) {
			$pathStart = getCaller('dir');
		} else { //is_string
			$pathStart = $accessPath;
		}

		$path_ = realpath($path);

		return startsWith($path_, $pathStart);
	}

	# надо тестировать

// --s