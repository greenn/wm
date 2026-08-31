<?#1.0.1

function jsonTryDecode($data, $asArray = true){ //jsonTryDecode|dataTryJsonDecode|
	if (is_string($data)) {
		$json = json_decode($data, $asArray);
		if (!json_last_error()) {
			$data = $json;
		}
	}
	return $data;
}
