<?
//targets
//_Targets
_needphp('str/endsWith');

_kot::reg('targets', array(
	'nc' => array(
		'base' => 'Tgs'
	),
));

class kot_targets extends kot {

	static function prepare_items_data($datas){
		$list = array();
		foreach ($datas as $data) {
			$list []= static::prepare_item_data($data);
		}
		return $list;
	}

	//подготовливает информацию из базы для фронта
	static function prepare_item_data($data){
		static $target_datetime_fields = array('from', 'to');
		static $target_array_fields = array('station'); //L
		static $target_list_fields = array('list');
		static $target_boolean_fields = array('flag');
		static $target_tplInfo = array();

		if (!$target_tplInfo) {
			$target_tplInfo = kot_api::get_data_prop('list', 'targets/tpl-info');
		}

		$item = $data;

		$tmp = strtotime($data['date']);
		//$item['date'] = date('d.m.Y H:i:s', $tmp);
		$item['date'] = static::date_value_format($tmp);

		$item['aproovedTitle'] = prop($item, 'aprooved') ? 'Действующий' : 'Не активен';

		$item['forecast'] = prop($data, 'forecast', '-');

		//dx($data, $item['targets'], $target_tplInfo);
		foreach ($item['targets'] as $index => $target) {

			foreach ($target_datetime_fields as $field) {
				$value = prop($target, $field);
				if ($value) {
					$target[$field] = static::date_value_format($value, 'js-date'); //'js-time'
				}
			}

			foreach ($target_boolean_fields as $field) {
				$value = prop($target, $field);
				if (is_string($value)) {
					$target[$field] = $value === '1';
				}
				//d($value, !!$value, $target[$field]);
			}

			//L
			foreach ($target_array_fields as $field) {
				if (isset($target[$field])) {
					$value = $target[$field];
					$target[$field] = $value ? explode(',', $value): array();
				}
			}

			foreach ($target_list_fields as $field) {
				if (isset($target[$field])) {
					$value = $target[$field];
					$target[$field] = $value ? explode(',', $value): array();
					//d($target, $field, $value, $target[$field]); //здась массив

					//oo kot/r/targets/targets.class.inc:165
					switch ($target['name']) {
						case 'passes/station-freq':
						case 'passes/station-mcd': {
							foreach ($target[$field] as $index2 => $pair) {
								$values = explode(':', $pair);
								$target[$field][$index2] = array(
									'id' => $values[0],
									'passes' => $values[1],
								);
							}
						} break;
						case 'passes/route-ngpt': {
							foreach ($target[$field] as $index2 => $pair) {
								$values = explode(':', $pair);
								$target[$field][$index2] = array(
									'type' => $values[0],
									'id' => $values[1],
									'passes' => $values[2],
								);
							}
						} break;
					}
				}
			}

			//d($target['id'], $target['list']); //здась массив
			foreach ($target as $prop => &$value2) {
				if ($value2 === null) {
					//if ($prop === 'list') d('x', $prop, $value2, $target['id']);
					unset($target[$prop]);
					continue;
				}
				if (endsWith($prop, '-fix')) {
					$value2 = $value2 === '1';
				}
			}

			//dx(@$target['name'], $target);
			$tplInfo = prop($target_tplInfo, $target['name']);
			$target['tpl'] = $tplInfo;



			$item['targets'][$index] = $target;
			//if (isset($target['list']))
			//d($item, $index, $target['id'], @$target['list']); //здась массив
		}

		//dx($item['targets']);

		/*$item['html-date'] = join(' ', array(
			'<span>'.date('d.m.Y', $tmp).'</span>',
			'<span>'.date('H:i:s', $tmp).'</span>',
		));*/

		/*if (prop($item, 'id')) {
			$item['uid'] = $item['id'];
			unset($item['id']);
		}*/

		//d($item['targets']);

		return $item;
	}

	static function _prepare_db_target(&$target, $name = ''){
		static $dateTimeProps = array('from', 'to');
		static $listProps = array('list');
		static $booleanProps = array('flag');

		foreach ($booleanProps as $prop) {
			$bool = prop($target, $prop);
			if (is_string($bool)) {
				$target[$prop] = $bool === 'true';
			}
		}

		foreach ($dateTimeProps as $prop) {
			$date = prop($target, $prop);
			if ($date) {
				$dateTime = new DateTime($target[$prop]);
				$target[$prop] = $dateTime->format('Y-m-d H:i:s');
			}
		}

		foreach ($listProps as $prop) {
			$list = prop($target, $prop);
			if ($list) {
				//d($target, $list);
				foreach ($list as $index => $item) {
					if (is_array($item)) {
						$values = array_values($item);
						switch ($name) { //oo kot/r/targets/targets.class.inc:73
							case 'passes/station-freq':
							case 'passes/station-mcd': {
								$values = array($item['id'], $item['passes']);
							} break;
							case 'passes/route-ngpt': {
								$values = array($item['type'], $item['id'], $item['passes']);
							} break;
						}
						//d($name, $item, $values);
						$list[$index] = join(':', $values);
					}
				}
				$target[$prop] = join(',', $list);
			}
		}


		foreach ($target as $prop => &$value) {
			if (endsWith($prop, '-fix')) {
				$value = str2val($value);
			}
		}
		return $target;
	}

	static function date_value($time = false){
		return date('Y-m-d H:i:s', $time ? $time : time());
	}

	static function date_value_format($date, $format = 'front'){
		static $mapFormat = array(
			'db' => 'Y-m-d H:i:s',
			'js-time' => 'Y-m-d\TH:i',
			'js-date' => 'Y-m-d',
			'front' => 'd.m.Y H:i:s',
			'copy' => 'd/m/Y H:i:s',
		);

		if (is_numeric($date)) {
			$dateTime = new DateTime();
			$dateTime->setTimestamp($date);
		} else {
			$dateTime = new DateTime($date);
		}
		$format = prop($mapFormat, $format, $format);
		return $dateTime->format($format);
	}

	static function fake_forecast($cur, $date){

		$maxChange = 1500;
		if ($date) {
			$now = new DateTime(); // Текущая дата и время
			$lastUpdate = new DateTime($date);
			$diffSec = $now->getTimestamp() - $lastUpdate->getTimestamp();
			$diff = $now->diff($lastUpdate);
				//$minutes = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;
				//$hours = $diff->h + ($diff->days * 24);

			$maxChange = $diff->days * 100000 + $diff->h * 5000 + $diff->i * 100 + $diff->s;

			//if (!$maxChange) $maxChange = rand(0, 1);
			if (!$maxChange) {
				$maxChange = rand(1, 100) <= 82 ? 1 : 0; //82% 1 или 0
			}
		}


		if (!$cur) {
			$val = rand(1, 150000);
		} else {
			$val = intval($cur) + rand(0, $maxChange);
		}
		return $val;
	}
}
