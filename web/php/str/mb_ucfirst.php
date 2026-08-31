<?#0.5.2

//https://stackoverflow.com/questions/2517947/ucfirst-function-for-multibyte-character-encodings
function mb_ucfirst($string) {
	$strlen = mb_strlen($string);
	$firstChar = mb_substr($string, 0, 1);
	$then = mb_substr($string, 1, $strlen - 1);
	return mb_strtoupper($firstChar) . $then;
}