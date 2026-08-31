<?#1.1.0

_addphp('json/jsonPrettyEncode');

function jsonEncode($data, $pretty = true){
	return $pretty ? jsonPrettyEncode($data) : json_encode($data, JSON_UNESCAPED_UNICODE);
}