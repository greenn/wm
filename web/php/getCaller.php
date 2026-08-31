<?#6.0.1

/*
	getCaller::last('dir'), true, true)
	$uri = dirUrl(getCaller::last('file'), true, true)."$relName.php?$urlQuery";

*/
class getCaller {
	static function sliceInfo($data, $type = false){
		if (!$type) return $data;
		$res = prop($data, $type);
		switch ($type) {
			case 'dir': {
				$res = dirname($data['file']);
			} break;
			case 'path': {
				$res = $data['file'];
			} break;
		}
		return $res;
	}

	static function prev($incPrev = 0, $infoType = false){
		$callStack = debug_backtrace();
		$callerIndex = count($callStack) - 1 - $incPrev;
		$callerInfo = $callStack[$callerIndex];
		return static::sliceInfo($callerInfo, $infoType);
	}

	static function last($infoType = false){
		return static::prev(0, $infoType);
	}

	static function name($function, $infoType = false){
		$res = null;
		$callStack = debug_backtrace();
		foreach ($callStack as $index => $caller) {
			if ($caller['function'] == $function) {
				$res = $infoType === 'index' ? $index : static::sliceInfo($caller, $infoType);
				break;
			}
		}
		return $res;
	}
}

/*
	getCaller('dir');
	getCaller('path');
	getCaller('dir', 'du'),
	getCaller(true, 'du'),

	$callStack = debug_backtrace();
	$caller = $callStack[0]; - инициатора вызова

	dx(
		getCaller(),
		getCaller('dir'),
		getCaller('path')
	);
*/
//L === getCaller::last()
function getCaller($requestedInfo = false, $nameParentCaller = false){

	$phpCallStack = debug_backtrace();
	//d('getCaller', $phpCallStack);

	$callerInfo = false;

	if ($nameParentCaller) {
		foreach ($phpCallStack as $itemIndex =>$callerItem) if (!$callerInfo) {
			if ($callerItem['function'] == $nameParentCaller) {
				$callerInfo = $callerItem;
				$callerIndex = $itemIndex;
			}
		}
	} else {
		$callerIndex = count($phpCallStack);
		$callerInfo = array_pop($phpCallStack);
	}


	$res = $callerInfo;
	if ($requestedInfo === 'dir') {
		$res = dirname($callerInfo['file']);
	} else if ($requestedInfo === 'path') {
		$res = $callerInfo['file'];
	}
	//function
	//line
	//args

	return $res;
}