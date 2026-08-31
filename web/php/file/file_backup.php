<?#0.2.0

_needphp('t');
function file_backup($path, $dirname = true, $suffix_pattern = '[Y.m.d H-i-s.u]'){
	$suffix = udate($suffix_pattern, microtime());
	$ext = pathinfo($path, PATHINFO_EXTENSION);
	if ($dirname === true) $dirname = dirname($path);
	return file_copy($path, $dirname, basename($path, ".$ext").".$suffix.$ext");
}