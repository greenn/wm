<?#0.5.3

function startsWith($srcString, $needle) {
    $length = strlen($needle);
    return (substr($srcString, 0, $length) === $needle);
}

function mb_startsWith($srcString, $needle){
	$length = mb_strlen($needle);
	return (mb_substr($srcString, 0, $length) === $needle);
}