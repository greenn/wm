<?#2.20.1 - [o] для ko-конфигов
//[zm jsonEncode]
function jsonString($data, $prettyJson = false){
	$json = ($prettyJson && defined('JSON_PRETTY_PRINT'))
		? json_encode($data, JSON_PRETTY_PRINT)
		: json_encode($data);

	if (!$json) {
		$json = sprintf('{ "%s": "%s" }', 'json_error', jsonLastErrorMsg());
	}

	return $json;
}