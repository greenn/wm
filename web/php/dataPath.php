<?#5.1.2120
//использование array-пути для среза контекста
//oo dataPath.class


/*
    dataPath_error(null) - сбросить данные
    dataPath_error() - данные об ошибке {f|ao}
	dataPath_error(0) - title ошибки
	dataPath_error(1) - error prop
	dataPath_error(2) - error prop parent data
	dataPath_error(3) - path tail
*/
function dataPath_error(){
	static $data = false;
	$q = func_num_args();
	//d('dataPath_error', $q, func_get_args());
	if (!$q) return $data;
	if ($q === 1) {
		$arg1 = func_get_arg(0);
		if ($arg1 === null) return $data = false; //case: reset data
		else return is_array($data) ? $data[$arg1] : null; //case: вернуть данные ошибки по индексу
	}
	$data = func_get_args(); //case: rec data
	return null;
}

function dataPath($path, $context, $isOriginalCall = true){
	if ($isOriginalCall) dataPath_error(null);
	$name = array_shift($path);
	$isLastName = empty($path);
	if (!is_array($context)) {
		dataPath_error('wrong-value', $name, $context, $path);
		return null;
	}

	if (!is_stringable($name)) dx(1, $name, $context);
	if (!array_key_exists($name, $context)) {
		dataPath_error('wrong-prop', $name, $context, $path);
		return null;
	} else {
		$data = $context[$name];
		return $isLastName ? $data : call_user_func(__FUNCTION__, $path, $data, false);
	}
}

//eg has_dataPath(array('a', 'b', 'c'), array('a' => array('b' => array('c1' => 1 ))));
function has_dataPath($path, $context){
	dataPath($path, $context);
	return !dataPath_error();
}



/*
    [eg] /web/test/web/php/dataPath.php
*/
function dataPath2($path, $context, $errorValue = null, $errorCtx = null){
    if (is_object($context)) $context = (array) $context;
    if (!is_array($context)) {
        //dx(is_callable($errorValue), $errorValue);
        return !is_callable($errorValue) ? $errorValue : call_user_func($errorValue, 'missed context', array('pathTail' => $path, 'ctxTail' => $context), $errorCtx);
    }
    $name = array_shift($path);
    $lastName = empty($path);
    d($context, $name);
    if (!isset($context[$name])) {
        //dx(is_callable($errorValue), $errorValue);
        return !is_callable($errorValue) ? $errorValue : call_user_func($errorValue, 'wrong context', array('missingName' => $name, 'pathTail' => $path, 'ctxTail' => $context), $errorCtx);
    } else {
        $data = $context[$name];
        return $lastName ? $data : call_user_func(__FUNCTION__, $path, $data, $errorValue);
    }
}

#1.14.20
function dataPath1($path, $context, $errorValue = ''){
    if (!is_array($context)) {
        return !is_callable($errorValue) ? $errorValue : call_user_func($errorValue, 'missed context', array('pathTail' => $path, 'ctxTail' => $context));
    }
    $name = array_shift($path);
    $lastName = empty($path);
    if (!isset($context[$name])) {
        return !is_callable($errorValue) ? $errorValue : call_user_func($errorValue, 'wrong context', array('missingName' => $name, 'pathTail' => $path, 'ctxTail' => $context));
    } else {
        $data = $context[$name];
        return $lastName ? $data : call_user_func(__FUNCTION__, $path, $data, $errorValue);
    }
}