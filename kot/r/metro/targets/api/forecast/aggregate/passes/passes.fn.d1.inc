<?php


function generatekotPasses($totalPasses, $minPasses, $maxPasses, $mostCommonLow, $mostCommonHigh) {
	$distribution = [];

	// Заполняем распределение нулями
	for ($i = $minPasses; $i <= $maxPasses; $i++) {
		$distribution[$i] = 0;
	}

	// Генерируем распределение
	for ($i = 0; $i < $totalPasses; $i++) {
		// Для простоты используем равномерное распределение, но можно использовать и другие
		$passes = mt_rand($mostCommonLow, $mostCommonHigh);

		if (isset($distribution[$passes])) {
			$distribution[$passes]++;
		}
	}

	// Нормализуем распределение
	$factor = $totalPasses / array_sum($distribution);
	foreach ($distribution as $passes => $count) {
		$distribution[$passes] = round($count * $factor);
	}

	return $distribution;
}

$totalPasses = 9000000; // 9 млн
$minPasses = 1;
$maxPasses = 20;
$mostCommonLow = 2;
$mostCommonHigh = 6;

$distribution = generatekotPasses($totalPasses, $minPasses, $maxPasses, $mostCommonLow, $mostCommonHigh);

// Выводим распределение
dx($distribution);
