<?#1.3.0

function rootLess($pathString, $slashAlign = false, $ROOT = true){
	if ($ROOT === true) $ROOT = $_SERVER['DOCUMENT_ROOT'];
    $regas = array(
        '~^'.preg_quote(str_replace('\\', '/', $ROOT)).'~',
        '~^'.preg_quote(str_replace('/', '\\', $ROOT)).'~'
    );

    $resPath = preg_replace($regas, '', $pathString);

    if ($slashAlign) {
	    $resPath = str_replace('\\', '/', $resPath);
    }
    return $resPath;
}

function hostLess($pathString){
	$regas = array(
		'~^'.preg_quote(hostUrl).'~',
		'~^'.preg_quote(hostName).'~',
		'~^'.preg_quote(domain).'~'
	);

	$resPath = preg_replace($regas, '', $pathString);

	return $resPath;
}