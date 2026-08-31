<?#2.1

function utf_str($s) {
	return iconv("UTF-8", "Windows-1251", $s);
}