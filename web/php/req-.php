<?#4.15

function req($path = null) {
	//wt req
	static $stack = array();
	if (!func_num_args()) return $stack;
	if (!isset($stack[$path])) $stack[$path] = 0;
	$stack[$path]++;
	//\

    require_once $path;
}

function req_try(){
    //dx(func_get_args());
    foreach (func_get_args() as $path) {
        //d($path);
        if (is_array($path)) {
            return call_user_func_array('req_try', $path);
        } else if (is_file($path)) {
            //d($path);
            req($path);
            return true;
        }
    }
    return false;
}

function req_self($path) {
    _addphp('getCaller');
    $dir = getCaller('dir');
    $path = ltrim($path, '\/');
    return req_try(
        "$dir/$path", "$dir/$path.php", "$dir/$path.inc"
        //,"{$dir}$path", "{$dir}$path.php", "{$dir}$path.inc"
    );
}

function req_root($path) {
    $path = ltrim($path, '\/');
    return req_try(ROOT."/$path", ROOT."/$path.php", ROOT."/$path.inc");
}

function req_web($path) {
    $path = ltrim($path, '\/');
    return req_try(WEB."/$path", WEB."/$path.php", WEB."/$path.inc");
}

function req_inc($path) {
    $path = ltrim($path, '\/');
    return req_try(INC."/$path", INC."/$path.php", INC."/$path.inc");
}