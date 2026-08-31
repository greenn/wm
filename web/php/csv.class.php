<?#0.1.0

class csv {

	static function read($path, $delimiter = true, $encode = false) {
		if ($delimiter == true) $delimiter = ';';
		if ($encode == true) $encode = 'Windows-1251';
		$file = file($path);
		$content = [];
		foreach ($file as $line) {
			if ($encode) $line = iconv($encode, "UTF-8", $line);
			$content[] = str_getcsv($line, $delimiter);
		}
		return $content;
	}


	static function read2arr($path){ //read_q
		return array_map('str_getcsv', file($path));
	}
}

