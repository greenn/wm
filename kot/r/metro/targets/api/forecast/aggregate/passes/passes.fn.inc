<?php

//dx($interval, $_ctx);

function generatekotPasses($totalPasses, $mean, $sd, $max = 20) {
	$distribution = [];

	for ($i = 0; $i < $totalPasses; $i++) {
		$x = mt_rand() / mt_getrandmax();
		$y = mt_rand() / mt_getrandmax();

		// Используем преобразование Бокса-Мюллера для генерации нормального распределения
		$z = sqrt(-2 * log($x)) * cos(2 * M_PI * $y);

		// Преобразуем z-оценку в нашу задачу
		$passes = round($z * $sd + $mean);

		// Ограничиваем количество проходов
		if ($passes < 1) {
			$passes = 1;
		} elseif ($passes > $max) {
			$passes = $max;
		}

		if (!isset($distribution[$passes])) {
			$distribution[$passes] = 0;
		}

		$distribution[$passes]++;
	}

	ksort($distribution);
	return $distribution;
}


