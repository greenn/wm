<?
_needphp('json');
_needphp('fq/str/str2val');
_needphp('file/move_file');

$Self; $_ctx; $food; $opt; $set; $prm; $status; $result;

$_mergeDeep = true;
$_kSort = true;

$target = $set['plate'];
if (!$target) {
	$status['протест'] = 'не ем без тарелки'; //нет файла
	return;
}


//if (_prop($opt, 'json')) {

	if (_prop($opt, 'json-filter-comment')) {
		//$food = preg_replace('/^\s*\/\/.*$/m', '', $food);

		$commentLinesCount = 0;
		$food = preg_replace_callback(
			'/^\s*\/\/.*$/m',
			function ($matches) use (&$commentLinesCount) {
				$commentLinesCount++;
				return '';
			},
			$food
		);

		$status['comment-replaced'] = $commentLinesCount;
	}

	$jsonData = jsonTryDecode($food);
	//dx(json_last_error(), jsonLastErrorMsg(), $jsonData);

	if (json_last_error()) {
		if (_prop($opt, 'json-try-fix')) {
			$food = "[$food]";
			$jsonData = jsonTryDecode($food);
			$status['fixed'] = !json_last_error();
		}
	}

	if (json_last_error()) {
		$status['json-error'] = json_last_error().': '.jsonLastErrorMsg();
	}


	if (is_array($jsonData)) {

		$cutlery = _prop($set, 'cutlery');



		//step: Дополнительный обработчик
		if ($cutlery) {
			$cutleryPath = $Self::path("api/cutlery/$cutlery.php");
			$status['приборы'] = is_file($cutleryPath) ? 'есть' : 'отсутвуют';
			//dx('обработчик', $cutlery, is_file($cutleryPath));

			if (is_file($cutleryPath)) {
				include $cutleryPath;
			} else {
				$status['название-приборов'] = [$cutlery, $cutleryPath];
			}

		}





		$jsonPath = $Self::path("stomach/json/$target.json");
		//$status['тарела'] = is_file($jsonPath) ? 'есть' : 'бумажная';

		if (is_file($jsonPath)) {

			if (_prop($opt, 'json-merge-data')) {
				$jsonData1 = jsonFile_get_data($jsonPath);
				if (is_array($jsonData1)) {
					$isMerged = false;
					if ($cutlery) {
						$cutleryMergerPath = $Self::path("api/cutlery/$cutlery.merge.php");
						if (is_file($cutleryMergerPath)) {
							include $cutleryMergerPath;
							$isMerged = true;
						}
					}
					if (!$isMerged) {
						if ($_mergeDeep) {
							$jsonData = array_replace_recursive($jsonData1, $jsonData);
						} else {
							$jsonData = array_replace($jsonData1, $jsonData);
						}

						$status['merged'] = strlen(json_encode($jsonData)) - strlen(json_encode($jsonData1));
						if ($_kSort) ksort($jsonData);
					}

				}
			}

			if (_prop($opt, 'json-backup-data')) {
				$dateSuffix = date('ymd-his'); //'y-m-d_h-i-s'
				$backupPath = $Self::path("sheet/json-backup/$target.$dateSuffix.json");
				$state = copy_file($jsonPath, $backupPath, COPY_FILE__EXIST_RENAME);
				$status['backup'] = $state;
			}


		}


		$state = jsonFile_put_data($jsonPath, $jsonData, true);
		$status['created'] = $state;

		//step: Сохранить файл в зону хранения
		if (_prop($opt, 'json-save')) {
			$dateSuffix = date('ymd-his'); //'y-m-d_h-i-s'
			$savedPath = $Self::path("sheet/json/$target.json"); //место хранения файла

			//case: если место занятно, то перемещаем текущий файла хранения в backup-зону
			if (is_file($savedPath)) {
				$backupSavedPath = $Self::path("sheet/json-backup/$target.json");
				$state = move_file($savedPath, $backupSavedPath, MOVE_FILE__EXIST_RENAME);
				preg_match('/\[\d+\]/', basename(_prop(_x('php/move_file'), 'exist-rename')), $matches);
				$status['копия'] = _prop($matches, array(0));
			}

			$state = copy_file($jsonPath, $savedPath, COPY_FILE__EXIST_REWRITE);
			$status['сохранено'] = basename($state);
		}
	}


//}

$result += array(
	'json-data' => $jsonData,
	'json-error-msg' => jsonLastErrorMsg(),
	'json-error' => json_last_error(),
);
