<?#0.3.1
//oo iq/test/php/ar-isLast.php


function isLastOf($index, $total) {
	if (is_array($total)) $total = count($total);
	return $index === ($total - 1);
}

function getLastKey($array){
	end($array); // Перемещаем внутренний указатель на последний элемент
	return key($array);
}

function isLastKey($array, $currentKey) {
	return getLastKey($array) === $currentKey;
}

function arrayKeyLast($array) {
	$keys = array_keys($array); // Получаем массив ключей
	return empty($keys) ? null : end($keys); // Возвращаем последний ключ
}

