<?#7.0.14

function php($phpName){

    static $specCalls = array('print', 'echo', 'include', 'include_once');

	//мешочек сахара
	$callStack = explode(' ', $phpName);
	$chainCallingRegistred = count($callStack) > 1;
	//d($chainCallingRegistred);
	if ($chainCallingRegistred) {
		return call_user_func_array('_sphp', func_get_args());
	}
	#)

	$_specCalls = in_array($phpName, $specCalls);
	$needInclude = !is_callable($phpName) && !$_specCalls;

	//d($phpName, $needInclude, is_callable($phpName), function_exists($phpName));
	if ($needInclude) {
		addphp($phpName);
	}

	$arguments = func_get_args();
	array_shift($arguments); //remove first argument which is $phpName

	if (is_callable($phpName)) {
		//d($phpName, $arguments);
		return call_user_func_array($phpName, $arguments);
	}

	if ($_specCalls) {
		foreach ($arguments as $argument) {
			switch ($phpName) {
				case 'echo': echo ($argument); break;
				case 'print': print ($argument); break;
				case 'include_once': include_once ($argument); break;
				case 'include': include ($argument); break;
			}
		}
	}
	
	return; //void
}


#3.1.14
//очень сладкий сахар для 'call1 call2', где call2 использует на вход один аргумент - результат call1
//[ad - второй аргумент, как определение или наличие дополнительных аргументов дял функций]
function _sphp($callChain){
	//id explode by' && ' //r if detected ~  php ('reversePhp') //_php ///rphp //php_r
	$callStack = explode(' ', $callChain);
	$callStack = array_reverse($callStack);

	//echo '<plaintext>', var_dump($callStack);
	
	foreach ($callStack as $index => $callName) {
		if ($index === 0) { //firstCall
			$arguments = func_get_args();
			$arguments[0] = $callName; //remove first argument and place instead the Caller
		
			$res = call_user_func_array('php', $arguments);

		} else {
			//d($callName, $res);
			$res = php($callName, $res);

		}
		
	}
		
	return $res;
}

////кусковые наборы бб/////
//include_once PHP.'/aphp.php'; //тростниковый сахар