<?#1.3.1234
/*
	man:
		iq/man/log
		(struct) php/log/log.man
*/
_needphp(
	'_s',
	'file/ensureDir'
);

define('LOG_NS', 'LOG'); //имя переменной в сессии

class log {
	static $list = array(); //данные текущего запроса
	static $sid ; //id текущей сессии
	static $rid = 0; //id текущешго запуска (обращения, запроса, request'а)

	static $store; //место хранения в файле
	static $inited = false;
	static function init($saveFileName = false){
		if (!static::$inited) {
			static::$inited = true;
			log::$sid = session_id();
			log::$rid = (string) microtime(true);
		}
		if ($saveFileName) static::save($saveFileName);
	}

	static function getCallerLine($incIndex = 1, $ctx = false){
		$callStack = $ctx ? $ctx : debug_backtrace();

		$callIndex = 0 + $incIndex;
		$callCtx = $callStack[$callIndex];

		$path = rootLess($callCtx['file']);
		$path = ltrim($path, '/\\');
		$line = "$path:{$callCtx['line']}";

		//052
		if (!1) dx(
			$callCtx,
			$callStack
		//$callStack[$callIndex],
		//$callStack[count($callStack) - 1] //last
		);
		return $line;
	}

	static function rec($text, $ctx = null, $type = 'log'){
		static::init();

		//step: getCallerLine
		$line = static::getCallerLine(2);
		//dx($line);

		$data = array(
			'time' => microtime(true),
			'line' => $line,
			'type' => $type,
			'msg' => $text,
			'ctx' => is_array($ctx) ? $ctx : array(),
		);

		static::_rec($data);
	}

	//установка места для сохранения в файл
	static function save($sid = true){
		if ($sid === true) $sid = static::$sid;
		$path = PHP."/log/db/{$sid}.json";
		ensureFileDir($path);
		static::$store = $path;
	}

	static function reset(){
		_s(LOG_NS, array());
	}

	//пишим запись в лог
	private static function _rec($data){

		static::$list []= $data;

		//step: save to session
		//      время запроса: uri запроса, логи-в-запросе
		//  хранение всех запросов текущей сессии
		s::data_set_key(LOG_NS, static::$rid, array(
			'uri' => URI,
			'items' => serialize(static::$list),
		));


		//step: save to file
		if (static::$store) {
			static::_save();
		}
	}

	//пишим лог в файл
	private static function _save(){
		$file = static::$store;
		jsonFile_put_data($file, s(LOG_NS));

		//бекап файла, если он больше 1Мб
		if (filesize($file) > 1/*Мб*/ * 1024 /*Кб*/ * 1024 /*байт*/) {
			$destPath = dirname($file).'/b/'.basename($file, '.json').'/'.time().'.json';
			move_file($file, $destPath);
			static::reset();
		}
	}

	//фильтруем данные лога (log, error, msg)
	static function typeFilter($filter = false, $data = true) { //ak dataList
		$resData = array();
		if ($filter) $filter = (array) $filter;
		if ($data === true) $data = static::$list;
		foreach ($data as $item) {
			//$item = unserialize($data);
			$type = prop($item, 'type');
			///d($type, $item);
			$match = !$filter || in_array($type, $filter);
			if ($match) {
				$resData []= $item;
			}
		}
		return $resData;
	}

	//фильтруем данные логов
	static function dataFilter($data, $filter = false, $tmp = false){
		$resData = array();
		foreach ($data as $key => $item) { //requestTime => $requestData
			if ($tmp && ($tmp > $key)) continue;
			$item['items'] = static::typeFilter($filter, $item['items']);
			if ($item['items']) {
				$resData[$key] = $item;
			}
		}
		return $resData;
	}

	static function getData($rid = false, $unwrap = true, $logData = true){
		if ($logData === true) $logData = _s(LOG_NS);
		$res = array();
		if ($rid) {
			$res[$rid] = $logData[$rid];
		} else {
			$res = $logData;
		}

		if ($unwrap) {
			$res = static::unwrapData($res, $unwrap);
		}

		return $rid ? $res[$rid] : $res;
	}

	static function slogToHtml_($_args){
		$msg = "[{$_args[0]}] {$_args[1]}";
		$ctx = array_slice($_args, 2);
		$hCtx = static::ctxToHtml($ctx);
		return "<div>$msg</div>$hCtx";
	}

	static function ctxToHtml($ctx){
		//gIncr('preventHeaders');
		ob_start();
		call_user_func_array('d', $ctx);
		$html = ob_get_clean();
		//gDecr('preventHeaders');
		return $html;
	}

	static function unwrapData($logData, $unwrapType){
		if (!($logData && $unwrapType)) return null;
		$unsetCtx = $unwrapType === 'html-only';
		$doHtml = $unwrapType === 'html' || $unsetCtx;

		foreach ($logData as $rid => $log) {
			$logItems = unserialize($log['items']);
			if ($logItems && $doHtml) {
				foreach ($logItems as $index => &$data) {
					$data['ctx-html'] = static::ctxToHtml($data['ctx']);
					if ($unsetCtx) unset($data['ctx']);
				}
			}

			$logData[$rid] = $log;
			$logData[$rid]['items'] = $logItems;
		}
		return $logData;
	}
}