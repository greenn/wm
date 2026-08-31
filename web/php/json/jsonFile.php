<?#1.1.0

_needphp('file');

function jsonFile_put_data($path, $data, $pretty = true) {
	$json = jsonEncode($data, $pretty);
	$success = save_file($path, $json);
	return $success;
}

function jsonFile_get_data($path, $asArray = true){ //mb jsonFile_getData
	$data = null;
	if (is_file($path)) {
		$json = file_get_contents($path);
		$data = json_decode($json, $asArray);
		//if (!$json && json_last_error()) d($msg = jsonLastErrorMsg());
	}
	return $data;
}