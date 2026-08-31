<?#0.3.0

_needphp('s/not_init');
//для хранения результата в кеше сессии
function _dirToArray(/*? $rebuildCache = false, */$pathRequest, $depth = -1, $keepDots = true){
	$res = array();

	$rebuildCache = false;

	$callArgs = func_get_args();
	if (is_bool($callArgs[0])) {
		$rebuildCache = $callArgs[0]; //снимаем первый аргумент
		$callArgs = array_slice($callArgs, 1);
	}

	$pathRequest = $callArgs[0];
	if ($path = realpath($pathRequest)){
		s_init(); //начать сессию, если не начата

		$sn = 'DtA_'.hash('adler32', serialize($callArgs));

		if (!$rebuildCache && sHas($sn)) {
			$res = s($sn); //берём из сессии
		} else {
			$res = call_user_func_array('dirToArray', $callArgs);
			s($sn, $res); //добавляем в сессию
		}
	}

	return $res;
}
