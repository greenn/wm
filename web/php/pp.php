<?#0.2.15
_needphp('pp/propPath');



function pp($data, $path/* ¦ $data, $path, $value ¦ true, $data, $path ¦ null, $data, $path*/) {
	$args = func_get_args();
	$numArgs = count($args);

	if ($numArgs === 2) {
		//d('case get', $data, $path);
		return propPath::get($data, $path);
	} else if ($numArgs === 3) {
		$isAct = $args[0] === true || $args[0] === null;
		if ($isAct) {

			list($act, $data, $path) = $args;
			//d('case act', $act, $data, $path);
			if ($act === null) {
				//d('case unset', $data, $path);
				$data = propPath::unset($data, $path);
			} else if ($act === true) {
				//d('case has', $data, $path);
				return propPath::has($data, $path);
			}

		} else {
			//case set:
			$value = $args[2];
			$data = propPath::set($data, $path, $value);
			dx('case set', $args[0], $data, $path, $value);
		}
	}
	return $data;
}



/*

$data = ['a' => 1, 'b' => '2'];
$path = ['a', 'c'];

// Получение значения
$result = pp($data, ['a', 'b', 'c']);

// Установка значения
pp($data, ['a', 'b', 'c'], 'новое значение');

// Проверка наличия
$exists = pp(true, $data, ['a', 'b', 'c']);

// Удаление
pp(null, $data, ['a', 'b', 'c']);


*/