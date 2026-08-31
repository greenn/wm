<?#0.1

function sameUri($str1, $str2) {
	//return strtok($str1, '?') === strtok($str2, '?');
	return trim(strtok($str1, '?'), '/') === trim(strtok($str2, '?'), '/');
}