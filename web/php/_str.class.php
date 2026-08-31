<?//dd

class _str {
	static function raw_cut($str, $substr, $pos = 0){
		$length = strlen($substr);
		return substr($str, $pos + $length);
	}

}