<?#0.0.1

function pickProps($keys, $data){
	$result = array();
	foreach ((array)$keys as $key) {
		$result[$key] = prop($data, $key);
	}
	return $result;
}