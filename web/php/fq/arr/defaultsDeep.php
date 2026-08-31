<?#2.1.0 GPT4


function defaultsDeep() {
	$args = func_get_args(); // Получаем все аргументы функции
	if (count($args) < 2) {
		return $args[0] ?? []; // Если аргументов меньше двух, возвращаем первый аргумент или пустой массив
	}

	$target = array_shift($args); // Извлекаем первый аргумент как целевой массив
	if (!$target) $target = array();

	foreach ($args as $defaults) {
		if ($defaults) { //my-add
			foreach ($defaults as $key => $value) {
				if (!isset($target[$key])) {
					$target[$key] = $value;
				} elseif (is_array($value) && is_array($target[$key])) {
					$target[$key] = defaultsDeep($target[$key], $value); // Рекурсивно применяем defaultsDeep
				}
			}
		}
	}

	return $target;
}


	function defaultsDeep_v1($target, $defaults) {
		foreach ($defaults as $key => $value) {
			if (!isset($target[$key])) {
				$target[$key] = $value;
			} elseif (is_array($value) && is_array($target[$key])) {
				$target[$key] = defaultsDeep_v1($target[$key], $value);
			}
		}
		return $target;
	}

function defaultsDeepForCtxProp($set, $prop, $nextData) {

}
