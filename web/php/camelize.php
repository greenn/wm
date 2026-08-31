<?#1.6
_needphp('str');

/*
    transform aaa-bb-cc to aaaBbCc
*/
function camelize($string){
	$parts = explode('-', $string);
	$parts = array_map('ucfirst', $parts);
	$string = implode('', $parts);
	return lcfirst($string);
}


function mb_camelizeName($string) {
	$_string = preg_replace("/[^A-Za-z0-9А-Яа-я]/u", '-', $string);
	$_string = preg_replace('/-+/', '-', $_string);
	$parts = explode('-', $_string);
	$parts = array_map('mb_ucfirst', $parts);
	$string = implode('', $parts);
	return $string;
}