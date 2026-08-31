<?
function is_includable($path){
	static $includableExts = array('php', 'inc');
	//$path = is_string($var) ? realpath($var) : false;
	return $path
	       && is_file($path)
	       && in_array(pathinfo($path, PATHINFO_EXTENSION), $includableExts)
	;
}