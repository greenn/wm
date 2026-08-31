<?#9.5.5 == L = s.class / _s()
// про сессии
// _needphp('s/not_init'); - использовать s, но не запускать сессию
//[rb via xvar ~ static s::]


//dx(@end($dbg = debug_backtrace())['file'], $dbg); //- не показывает точного места, но показывает файл-вызова
/*
    !  - имя переменной не может быть is_numeric [nd]
*/
_needphp('x');
_needphp('ck');

function s_inited(){
	return session_id() !== '';
}


function s_init(){
	//session_cache_limiter('public');


	if (isset($GLOBALS['S_CUSTOM_ENV'])) {
		s_env($GLOBALS['S_CUSTOM_ENV']);
	}

	if (!s_inited() && !headers_sent()) {
		@session_start();
		//header_remove(); //[on - перестёт работать сессия / не сохраняет данные при перезагрузке]
		header_remove('Expires');
		header_remove('Cache-Control');
		header_remove('Pragma');

		# http://php.net/manual/ru/session.configuration.php#ini.session.cache-limiter
		# http://php.net/manual/ru/function.session-cache-limiter.php
		//Expires: Thu, 19 Nov 1981 08:52:00 GMT
		//Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0
		//Pragma: no-cache
	}
}

function s_close(){
	$_SESSION = array();
	session_destroy();
}

//tr
function s_env($data){
	if (is_array($data)) {
		if (isset($data['SID']) && ($data['SID'] !== ck('PHPSESSID'))) {
			ck('PHPSESSID', $data['SID']);
			if (isset($data['set_cookies']) && is_array($data['set_cookies'])) {
				foreach ($data['set_cookies'] as $ckName => $ckVal) {
					ck($ckName, $ckVal);
				}
			}
		}
		if (isset($data['sync_cookies']) && is_array($data['sync_cookies'])) {
			foreach ($data['sync_cookies'] as $ckName => $ckVal) {
				ck($ckName, $ckVal);
			}
		}
	}
}


function s(/*$sessionVarName, $valueToSet*/){
    switch (func_num_args()) {
        case 0;
            return $_SESSION;

        case 1;
            $sessionVarName = func_get_arg(0);
            return sHas($sessionVarName) ? $_SESSION[$sessionVarName] : null;

        case 2;
            $sessionVarName = (string) func_get_arg(0);
            $valueToSet = func_get_arg(1);

            //d($sessionVarName, $valueToSet);

            $_SESSION[$sessionVarName] = $valueToSet;
            return $valueToSet;
    }
}



function sHas($sessionVarName){
	//d($sessionVarName);
	return isset($_SESSION) && array_key_exists($sessionVarName, $_SESSION);
	//$data = isset($_SESSION) ? $_SESSION : array();
    //return array_key_exists($sessionVarName, $data);
}

function sDel($sessionVarName) {
    if ($sessionVarName === true) {
    	//case: clean all session data
	    $_SESSION = array();
    } else if (sHas($sessionVarName)) {
        unset($_SESSION[$sessionVarName]);
        return true;
    } else {
        return false;
    }
}


function s_push($name, $value, $prop = null){
	$isAssoc = func_num_args() > 2;

	$x = sHas($name) ? s($name) : array();

	if (!is_array($x)) {//0
		$x = array($x);
		//[mb] $x = array(); //[mb] при опции {%arg4}
	}

	if ($isAssoc) {
		$x[$prop] = $value;
	} else {
		$x []= $value;
	}
	//d($x);
	return s($name, $x);
}


function s_inc($counterName) {
    //d(sHas($counterName), s($counterName), $_SESSION);
    $inc = sHas($counterName) ? s($counterName) : 0; //(int)
    if (!is_numeric($inc)) $inc = 0;
    return s($counterName, ++$inc);
}


_needphp('serialization');
//serialization session
function ss(){
	//dx(12, $_SESSION);

	$case = func_num_args();
	$args = func_get_args();
	if ($case == 2) $args[1] = serialize($args[1]);
	$data = call_user_func_array('s', $args);
	switch ($case) {
		case 0: //case: все данные сессии, пробуем распаковать
			foreach ($data as &$value) {
				$value = try_unserialize($value);
			}
			break;
		case 1: //case: полученыее данные из сессии, пробуем распаковать
			$data = try_unserialize($data);
			break;
		case 2: //case: установка значения в ser-сессию, возвращаем незапакованное значение
			$data = func_get_arg(1);
			break;
	}
	return $data;
}

function s_prop($name, $prop, $otherwise = null) {
	return prop(s($name), $prop, $otherwise);
}


function s_set($name, $prop, $value){
	$s = sHas($name) ? (array) s($name) : s($name, array());
	$s[$prop] = $value;
	return s($name, $s);
};

//eg web/test/web/php/s/s_setChain.php
function s_setChain($name, $props, $value){
	$data = sHas($name) ? s($name) : array();
	set_propChain($data, $props, $value);
	return s($name, $data);
};

//:::

if (!x('prevent_s_init')) {
	s_init();
	//dx('inited', s_inited());
}

if (s_inited()) {
	include PHP.'/s/ccc.php';
	include PHP.'/s/sss.php';
}

//include PHP.'/s/sv.php';
//include PHP.'/s/sInit.php';
