<?//2

_needphp('rootLess');

function dirVar($path = false){

	static $cache = array();

	if (!$path)
		$path = php('getCaller', 'dir', 'dirVar');


	if (isset($cache[$path]))
		return $cache[$path];

	$relPath = str_replace('\\', '/', rootLess($path));

	$varName = str_replace(array('/', '\\', '.'), array('_', '_', ''), trim($relPath, '/'));

	return $cache[$path] = $varName;
}

function dirVar_c($path = false){

	if (!$path)
		$path = php('getCaller', 'dir', 'dirVar');

	if (cached($path))
		return cache($path);

	$relPath = str_replace('\\', '/', rootLess($path));

	$varName = str_replace(array('/', '\\', '.'), array('_', '_', ''), trim($relPath, '/'));

	return cache($path, $varName);
}


