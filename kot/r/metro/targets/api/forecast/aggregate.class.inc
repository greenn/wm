<?

class targets_aggregate {
	static $perDay = 1000000;

	//+- 10% от
	static function getRandomPerDay($days = 1){
		if (is_array($days)) $days = prop($days, 'days', 1);
		$total = static::$perDay * $days;
		$lowerBound = $total * 0.9;
		$upperBound = $total * 1.1;
		return mt_rand($lowerBound, $upperBound);
	}


	static $curCoverage;

	static $map_passenger;
	static $map_card;
	static $map_sale;
	static $map_place;
	static $map_passes;
	static $map_restore;
	static $map_write;
	static $map_topup;
	static $map_helpdesk;
	static $map_services;
	static $map_message;


	static function prepare($targetName, $data){
		$resData = array();

		list($type, $name) = explode('/', $targetName);

		static $cache = array();
		if (!isset($cache[$type])) {
			$map = static::${"map_$type"};
			foreach ($map as $type => $mapSection) {
				foreach ($mapSection as $field => $cfg) {
					if (is_string($cfg)) $cfg = array($cfg);
					if (isOrdinal($cfg)) $cfg = array('src' => $cfg);
					if (is_string($cfg['src'])) $cfg['src'] = array($cfg['src']);
					$map[$type][$field] = $cfg;
				}
			}
			$cache[$type] = $map;
		}


		$map = $cache[$type][$name];
		//d($targetName, $data, $map);
		foreach ($map as $prop => $cfg) {
			$value = prop_hit($data, $cfg['src']);

			if ($value && !is_array($value)) {
				if ($glue = prop($cfg, 'glue')) {
					if (is_string($value)) {
						$value = $value ? explode($glue, $value) : array();
					}

					if ($pairProps = prop($cfg, 'pair')) {
						$pairGlue = ':';
						//d($value, $data, $cfg['src']);
						foreach ($value as $index => $pair) {
							$values = explode($pairGlue, $pair);
							$value[$index] = array();
							$value[$index][$pairProps[0]] = $values[0];
							$value[$index][$pairProps[1]] = $values[1];
						}
					}
					//d($glue, $value, $data, $cfg['src']);
				}
			}

			//dx($map, $cfg, $prop, $value);
			$resData[$prop] = $value;
		}

		return $resData;
	}

	static function convertInterval($intervalName){
		static $ruleMap = array();
		if (!$ruleMap) {
			//$info = kot_api::get_prop(array('data', 'list'), 'targets/tpl-info');
			//$info = kot_api::get_data_prop('list', 'targets/tpl-info');
			$ruleMap = kot_api::get_data_prop('info', 'ui/select-time-preset');

		}


		$ruleMap = array(
			'last-hour' => array('hour' => -1),
			'last-24h' => array('hour' => -24),
			'today' => array(),
			'yesterday' => array('day' => -1),
			'this-week' => array('day' => -date('N')),
			'last-7d' => array('day' => -7),
			'last-30d' => array('day' => -30),
			'last-90d' => array('day' => -90),
			'last-year' => array('year' => -1),
		);

		//d($intervalName, @$ruleMap[$intervalName]);
		$rule = prop($ruleMap, $intervalName, $ruleMap['today']);
		if (!$rule) {
			$errorArg = 'неизвестный интервал';
			if (!$intervalName) $errorArg = 'интервал не задан';
			$error = "Ошибка выбора интервала: $errorArg";
		}

		$dateFrom = new DateTime();
		$dateTo = new DateTime();
		foreach ($rule as $unit => $value) {
			$dateFrom->modify("{$value} {$unit}");
		}


		$interval = $dateFrom->diff($dateTo);
		$intervalDays = $interval->days;
		if ($intervalName === 'today') $intervalDays = 1;
		if ($intervalName === 'yesterday') $intervalDays = 2;

		return array(
			'name' => $intervalName,
			'from' => $dateFrom->getTimestamp(),
			'to' => $timestampTo = $dateTo->getTimestamp(),
			'days' => $intervalDays,
			//'error' => $error,
		);
	}



	static function generateNormalRandom($mean, $sd) {
		$x = mt_rand() / mt_getrandmax();
		$y = mt_rand() / mt_getrandmax();

		// Преобразование Бокса-Мюллера
		$z = sqrt(-2 * log($x)) * cos(2 * M_PI * $y);

		return $z * $sd + $mean;
	}

	static function randomNear($mean, $total){
		$sd = 2000;  //стандартное отклонение

		$randomNumber = static::generateNormalRandom($mean, $sd);

		// Ограничиваем диапазон числа
		$randomNumber = max(1, min($total, round($randomNumber)));

		return $randomNumber;
	}
}

include_once 'aggregate.cfg.inc';