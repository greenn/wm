<?//2-23


function dirUp($path = true, $times = 1) {

	if (func_num_args() == 1 && is_numeric($arg1 = func_get_arg(0))) {
		$times = $arg1;
		$path = true;
	}

	if ($path === true) {
		$path = php('getCaller', 'path', 'dirUp');
	}


	while ($times-- >= 0 ) {
	    $path = dirname($path);
    }

    return $path;
}

/*

    fix: dirUp(2, __FILE__)

*/