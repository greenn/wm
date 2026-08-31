<?#3.5.6
# https://chat.deepseek.com/a/chat/s/e13d9cc2-e22d-406e-9459-2886b637fc18
# https://chatgpt.com/c/67e0c7f0-ed28-8008-b3e7-e459901cc947

function getValueByPath($data, $path) {
	//d('getValueByPath', $data, $path);
	if (!$path || !is_array($data)) return null;

	$current = $data;
	foreach ((array)$path as $key) {
		if (is_array($current) && array_key_exists($key, $current)) {
			$current = $current[$key];
		} else {
			return null; // Если ключ не найден, возвращаем null
		}
	}
	return $current;
}


function isPathExists($data, $path) {
	//d('isPathExists', $data, $path);
	if (!$path || !is_array($data)) return false;
	$current = $data;
	foreach ((array)$path as $key) {
		if (is_array($current) && array_key_exists($key, $current)) {
			$current = $current[$key];
		} else {
			return false; // Если ключ не найден, возвращаем false
		}
	}
	return true;
}

function setValueByPath(&$array, $path, $value) {
	$ref = &$array;

	foreach ((array)$path as $key) {
		if (!isset($ref[$key]) || !is_array($ref[$key])) {
			$ref[$key] = [];
		}
		$ref = &$ref[$key];
	}

	$ref = $value;
}


function pushValueByPath(&$array, $path, $value) {
	$ref = &$array;

	foreach ((array)$path as $key) {
		if (!isset($ref[$key]) || !is_array($ref[$key])) {
			$ref[$key] = [];
		}
		$ref = &$ref[$key];
	}

	// Убедимся, что на конце действительно массив
	if (!is_array($ref)) {
		$ref = [$ref]; // если было скалярное значение — превращаем в массив
	}

	$ref[] = $value;
}
