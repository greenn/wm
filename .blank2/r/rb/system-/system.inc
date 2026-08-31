<?#0.3.0

_needphp('set');
_needphp('s/init');
_needphp('json');
_needphp('file/move_file');


x('rp_system', array(
	'baseDir' => $dir = dirname(__FILE__),
	'nc' => array(
		'base' => 'Sym',

		'tool-log' => 'ToLo',
		'tool-log-head' => 'ToLo-H',
		'tool-log-content' => 'ToLo-C',
		'tool-log-users' => 'ToLo-U',
		'tool-log-sessions' => 'ToLo-S',
		'tool-log-requests' => 'ToLo-R',
	),
	'nj' => array(
		'tool-log' => 'ToLo',
		'tool-log-filter' => 'ToLo_F'
	),
	'apiCtx' => array(
		'pathStart' => fileUrl($apiDir = "$dir/api", false),
		'config' => array('tokens' => array(
			'log/last-pid' => array(
				'get' => "$apiDir/log/_last-pid.get.php",
			),
			'log/data' => array(
				'get' => "$apiDir/log/_data.get.php",
			),
			'log/sid' => array(
				'get' => "$apiDir/log/_sid.get.php",
			),
			'log/uid' => array(
				'get' => "$apiDir/log/_uid.get.php",
			),
		))
	)
));

define('SYSLOG_NS', 'syslog');

//логирование данных для разработки
function _log($text/*, $ctxItem1, $ctxItemN*/){
	$args = array_slice(func_get_args(), 1);
	rp_system::log($text, $args);
}
function __log(){}

//системные сообщения (aka warn), которые можно выкидывать на страницу для информирования
function _msg($text/*, $ctxItem1, $ctxItemN*/){
	$args = array_slice(func_get_args(), 1);
	rp_system::log($text, $args, 'msg');
}

//системные ошибки, которые можно выкидывать на страницу для информирования
function _error($text/*, $ctxItem1, $ctxItemN*/){
	$args = array_slice(func_get_args(), 1);
	rp_system::log($text, $args, 'error');
}

//system debug Data
function _dd(){
	return rp_system::$log;
}

/*

openlog("имя вашей программы", LOG_PID | LOG_PERROR, LOG_LOCAL0);
syslog(LOG_WARNING,"Программа запущена");
...
// тут программа
...
syslog(LOG_WARNING, "Программа завершила выполнение");
closelog();


if (prop($data, 'type') === 'log' && has_prop($data, 'msg')) {
	syslog(LOG_DEBUG, $data['msg']);
}


*/

class rp_system extends site_rp {
	static $x = 'rp_system';
	static $log = array();
	static $rid = 0; //id текущешго процесса / запуска / запроса
	static $uid = false;

	static $dbg_sid = true;


//= LOG
	static function log_reset(){
		s(SYSLOG_NS, array());
	}

	static function _log($data){

		static::$log []= $data;

		s_set(SYSLOG_NS, static::$rid, array(
			'uri' => URI,
			'items' => serialize(static::$log),
		));
	}

	static function getCallerLine($incIndex = 1, $ctx = false){
		$callStack = $ctx ? $ctx : debug_backtrace();

		$callIndex = 0 + $incIndex;
		$callCtx = $callStack[$callIndex];

		$path = rootLess($callCtx['file']);
		$path = ltrim($path, '/\\');
		$line = "$path:{$callCtx['line']}";
		return $line;
		if (1) dx(
			$callCtx,
			$callStack
			//$callStack[$callIndex],
			//$callStack[count($callStack) - 1] //last
		);
	}
	static function log($text, $ctx = null, $type = 'log'){

		//step getCallerLine
		$line = static::getCallerLine(2);
		//dx($line);

		$data = array(
			'line' => $line,
			'msg' => $text,
			'type' => $type,
			'ctx' => is_array($ctx) ? $ctx : array(),
		);
		static::_log($data);

		static::dbgsave();
	}

	static function dbglogPath($sid = true){
		if ($sid === true) $sid = session_id();
		$uid = static::$uid ? static::$uid.'-' : '';
		return WEB."/log/dbg-site/{$uid}{$sid}.json";
	}

	private static function dbgsave(){
		//$sid = static::$dbg_sid;
		//if (static::$uid === 'CRON') $sid = 'cron-sid';
		$sid = x_val('ACC_USER_CUSTOM_SID', static::$dbg_sid);
		$file = static::dbglogPath($sid);
		//dx($file);

		jsonFile_put_data($file, s(SYSLOG_NS));
		//dx(filesize($file));

		if (filesize($file) > 1/*Мб*/ * 1024 /*Кб*/ * 1024 /*байт*/) {
			$destPath = dirname($file).'/b/'.basename($file, '.json').'/'.time().'.json';
			move_file($file, $destPath);
			static::log_reset();
		}
	}

	static function logData($filter = false) {
		$resData = array();
		if ($filter) $filter = (array) $filter;
		foreach (static::$log as $item) {
			//$item = unserialize($data);
			$type = prop($item, 'type');
			$match = !$filter || in_array($type, $filter);
			if ($match) {
				$resData []= $item;
			}
		}
		return $resData;
	}

	static function unwrapLogData($logData, $unwrapType){
		if ($logData && $unwrapType) {
			foreach ($logData as $rid => $log) {
				$logItems = unserialize($log['items']);
				if ($logItems && ($unwrapType === 'html')) {
					foreach ($logItems as $index => &$data) {
						ob_start();
						call_user_func_array('d', $data['ctx']);
						$data['ctx'] = ob_get_clean();
					}
				}

				$logData[$rid] = $log;
				$logData[$rid]['items'] = $logItems;
			}
		}
		return $logData;
	}

	static function getSessionLog($rid = false, $unwrap = true, $logData = true){
		$res = array();
		$list = $logData === true ? s(SYSLOG_NS) : $logData;

		if ($rid) {
			$res[$rid] = prop($list, $rid);
		} else {
			$res = $list;
		}

		$res = static::unwrapLogData($res, $unwrap);

		return $rid ? $res[$rid] : $res;
	}

	static function getSessionLogBySid($sid, $rid = false, $unwrap = true){
		$file = static::dbglogPath($sid);
		$logData = jsonFile_get_data($file);
		return static::getSessionLog($rid, $unwrap, $logData);
	}


	static function sortByLastDateDesc_cb($left, $right){
		return $left['lastDate'] < $right['lastDate'];
	}
//-
}

if (!sHas(SYSLOG_NS)) { //ensure-for-session-var
	rp_system::log_reset();
}


//rp_system::$rid = time(); //id для текущего запроса
rp_system::$rid = (string) microtime(true); //id для текущего запроса



