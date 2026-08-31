<?
_needphp('isAssoc');

_rb::reg('uc-upd', array(
	'className' => 'rb_uc_upd', //rb_ucUpd
	'nc' => array(
		'base' => 'upd'
	),
));

class rb_uc_upd extends rb {


	static function apply($processData, $globalInterval = false){
		$resList = array();

		foreach ($processData as $processItem) {
			if (isAssoc($processItem)) {
				$stepList = static::apply_list($processItem);
				//d($stepList);
			} else {
				//d($processItem, static::$last_interval, $resList, static::$break);
				$stepList = static::apply_bundle($processItem, static::$last_interval);
				//dx($stepList, static::$break);
			}
			$resList += $stepList;

			if (static::$break) {
				break;
			}
		}

		return $resList;
	}

	static $break = false;
	static $last_interval;
	static function apply_list($processData){
		$resList = array();
		foreach ($processData as $title => $interval) {
			$percentage = static::currentPercantageOfInterval($interval);

			$resList[$title] = $percentage;

			if ($percentage === 100) {
				static::$last_interval = $interval;
			} else {
				//останавливаем выполнение листинга, т.к. процесс не 100%
				static::$break = true;
				break;
			}
		}
		return $resList;
	}

	static function apply_bundle($cfg, $last_interval = false){
		list($interval, $list) = $cfg;

		//делаем поправку на последний интервал
		if ($last_interval) {
			$interval[0] = $last_interval[1];
		}

		//подготавливаем массив с периодами, вычисляем для каждого шага даты начала и конца
		list($start_time, $end_time) = static::intervalToTime($interval);
		$totalTime = $end_time - $start_time;
		$totalParts = array_sum($list);

		$resList = array();
		$itemEndTime = $start_time;
		foreach ($list as $title => $parts) {
			$itemStartTime = $itemEndTime; //начальное время шага = конечное время предыдущего шага
			$partsTime = ($parts / $totalParts) * $totalTime; //вычисленное время в секундах, относительно указанного веса и общего интервала

			$itemEndTime = $itemStartTime + $partsTime; //получаем конечное время шага
			$resList[$title] = array($itemStartTime, $itemEndTime);
		}


		$dbgList = array();
		foreach ($resList as $title => $interval) {
			$dbgList[$title] = array(
				date('Y-m-d H:i:s', $interval[0]),
				date('Y-m-d H:i:s', $interval[1]),
			);
		}
		//dx($dbgList);
			//dx($resList, $dbgList);



		return static::apply_list($resList);
	}


	// переводим значение интервала в timestamp
	static function intervalToTime($dateInterval){
		list($start_date, $end_date) = $dateInterval;

		$start_time = is_string($start_date) ? strtotime($start_date) : $start_date; // Начальное время
		$end_time = is_string($start_date) ? strtotime($end_date) : $end_date; // Конечное время

		return array($start_time, $end_time);
	}

	// получаем текущее значение интервала-дат в процентах
	static function currentPercantageOfInterval($dateInterval){
		list($start_time, $end_time) = static::intervalToTime($dateInterval);

		$current_time = time(); // Текущее время

		$elapsed_time = $current_time - $start_time; // Прошедшее время с начальной даты
		$total_time = $end_time - $start_time; // Общее время операции

		$percentage = ($elapsed_time / $total_time) * 100;
		$percentage = min(100, $percentage); // Ограничение до 100%

		return $percentage;
	}
}
