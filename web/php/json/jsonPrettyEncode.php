<?#1.3.0

function jsonPrettyEncode($data){ #5.0 //jb|jo|
	//dx(PHP_VERSION, version_compare(PHP_VERSION, '5.4.0', '>='));
	//dx($data, JSON_PRETTY_PRINT, JSON_UNESCAPED_UNICODE, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
	if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
		return json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
	} else {
		_needphp('json/json_readable_encode');
		return json_readable_encode($data);
	}
}