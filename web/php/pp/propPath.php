<?#3.0.1
//gpt assist (v0)

class propPath {
	public static function get($data, $path, $default = null) {
		foreach ($path as $key) {
			if (!is_array($data) || !array_key_exists($key, $data)) {
				return $default;
			}
			$data = $data[$key];
		}
		return $data;
	}

	public static function has($data, $path) {
		foreach ($path as $key) {
			if (!is_array($data) || !array_key_exists($key, $data)) {
				return false;
			}
			$data = $data[$key];
		}
		return true;
	}

	public static function set($data, $path, $value) {
		$tempData = $data; // Создаем копию исходного массива
		$temp = &$tempData; // Работаем с копией
		foreach ($path as $key) {
			if (!isset($temp[$key]) || !is_array($temp[$key])) {
				$temp[$key] = [];
			}
			$temp = &$temp[$key];
		}
		$temp = $value;
		return $tempData; // Возвращаем измененную копию

		$temp = &$data;
		foreach ($path as $key) {
			if (!isset($temp[$key]) || !is_array($temp[$key])) {
				$temp[$key] = [];
			}
			$temp = &$temp[$key];
		}
		$temp = $value;

		return $data;
	}

	public static function unset($data, $path) {
		$temp = $data;
		$lastKey = array_pop($path);
		foreach ($path as $key) {
			if (!isset($temp[$key]) || !is_array($temp[$key])) {
				return $data; // Если путь не существует, прерываем выполнение
			}
			$temp = &$temp[$key];
		}
		unset($temp[$lastKey]);
		return $data;
	}

}