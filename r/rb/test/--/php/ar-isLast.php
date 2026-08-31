<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('fq/arr/isLast');

// Пример использования:
$items = ['a', 'b', 'c'];
d($items);

	$lastKey = getLastKey($items);
	foreach ($items as $key => $value) {
		if ($key === $lastKey) {
			echo "<br />getLastKey / Последний элемент: $value";
		}
	}

//my er
function isLastKey($array, $lastKey) {
	return key($array) === $lastKey;
}

if (!true && 'isLastKey') {
	$lastKey = end($items);
	foreach ($items as $value) {
		if (isLastKey($items, $lastKey)) {
			echo "Последний элемент: $value\n";
		}
	}
}


//by gpt
function isLastByKey1($array, $currentKey) {
	// Устанавливаем внутренний указатель на последний элемент массива
	end($array);
	// Сравниваем ключ текущего (последнего) элемента с переданным ключом
	return key($array) === $currentKey;
}


if (true && 'isLastByKey') {
		foreach ($items as $key => $value) {
			/*if (isLastByKey($items, key($items))) {
				echo "Последний элемент: $value\n";
			}*/

			if (isLastByKey($items, $key)) {
				echo "<br />sLastByKey / Последний элемент: $value";
			}
		}
	}


//by gpt er
function isLastIteration($array) {
	// Сохраняем текущий элемент, чтобы не изменять внутренний указатель массива
	$currentElement = current($array);

	// Переходим к следующему элементу, чтобы проверить, является ли текущий последним
	$nextElement = next($array);

	// Возвращаем указатель на исходную позицию
	if ($currentElement !== false) {
		prev($array);
	}

	// Если следующий элемент равен false, значит текущий элемент - последний
	return $nextElement === false;
}

/*
	// Пример использования:
	$items = ['a', 'b', 'c'];
	foreach ($items as $value) {
		if (isLast($items)) {
			echo "Последний элемент: $value\n";
		}
	}
*/

if (!true && 'isLastIteration') {
	foreach ($items as $key => $value) {
		//d(isLastIteration($items));
		if (isLastIteration($items)) {
			echo "Последний элемент: $value\n";
		}
	}
}