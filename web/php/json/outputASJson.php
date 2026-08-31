<?#0.5.1

_needphp('x');
_needphp('json/jsonPrettyEncode');

function outputASJson($data, $headers = true, $filePath = null, $prettyOutput = true){

	//d(debug_backtrace());

	if ($headers !== false) { //null is ok
		$headers = array('json', 'utf8', 'nosniff', $headers);

		if ($filePath == true) {
			$filePath = getCaller('path');
		}
		if (is_string($filePath)) {
			$headers []= array('etag_file' => $filePath);
		}
	}

	if (!empty($headers)) {
		headers($headers);
	}

	//super-hack: для вставки данных после отправки хедеров
	//неапример об отправленых хедерах [oo R->dbgNotchDecl()]
	//dx(x('outputASJson'));
	$cfg = x('outputASJson');

	if ($upd = prop($cfg, 'updAfterHeaders')) {
		unset($cfg['updAfterHeaders']); x('outputASJson', $cfg); //удаляаем опцию после обнаружения / применения / испольщования / выполнения
		if (is_callable($xCall = prop($upd, 'xCall'))) {
			$xCallArgs = prop($upd, 'xCallArgs', array());
			if ($xPropData = prop($upd, 'xPropData')) x($xPropData, $data);
			if (prop($upd, 'xCallAddData')) array_push($xCallArgs, $data);

			$result = call_user_func_array($xCall, $xCallArgs);

			if ($xPropRes = prop($upd, 'xPropRes')) {
				$data = $xPropRes === true ? $result : x($xPropRes);
			}
		}
	}

	//echo json_encode($jsonData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
	//echo jsonEncode($data);

	//headers('html', 'utf8', 'nosniff', 'cache-off'); d($data);

	print $prettyOutput ? jsonPrettyEncode($data) : jsonEncode($data);

	//d(json_last_error());
}