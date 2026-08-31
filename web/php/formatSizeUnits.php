<?#0.3.1

function formatSizeUnits($bytes, $nullBytesMsg = 'пустой файл') {
	if ($bytes >= 1073741824) {
		$bytes = number_format($bytes / 1073741824, 2) . ' ГБ';
	}
	elseif ($bytes >= 1048576) {
		$bytes = number_format($bytes / 1048576, 2) . ' МБ';
	}
	elseif ($bytes >= 1024) {
		$bytes = number_format($bytes / 1024, 2) . ' КБ';
	}
	elseif ($bytes > 1) {
		$bytes = $bytes . ' байтов';
	}
	elseif ($bytes == 1) {
		$bytes = $bytes . ' байт';
	}
	else {
		$bytes = $nullBytesMsg;
	}

	return $bytes;
}

function formatSizeUnits_eng($bytes, $msg = 'empty file'){
	$res = formatSizeUnits($bytes, $msg);
	return strtr($res, array('байтов' => 'bytes', 'байт' => 'byte', 'КБ' => 'KB', 'МБ' => 'MB', 'GB' => 'ГБ'));
}

function filesizeFormat($path){
	$res = '-';
	if (is_file($path)) {
		$res = formatSizeUnits(filesize($path));
	}
	return $res;
}

function filesizeFormat_eng($path, $otherwise = '-'){
	$res = $otherwise;
	if (is_file($path)) {
		$res = formatSizeUnits_eng(filesize($path));
	}
	return $res;
}