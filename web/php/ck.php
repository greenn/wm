<?#4.2.0 - про cookies
//возможность хрнаить объект в куках, с помощью авто-конвертирования в json и обратно
_needphp('json');

define('cookiesOff', !isset($_COOKIE));
define('cookiesOn', !cookiesOff);

function ck_name($string){
    $res = strtr($string, array(
        '.' => '_',
        '+' => '_',
        '/' => '-',
    ));
    return $res;
}
/*
	eg
		ck('mb_test', array('opt' =>  126), true); установит obj-куку только для данного  =uri
*/
function ck(/*$cookieVarName, $valueToSet, ?$cookiesCtx*/){
    if (cookiesOff) return null;

    switch (func_num_args()) {
        case 0;
            foreach ($_COOKIE as $name => $value) {
                $_COOKIE[$name] = jsonTryDecode($value);
            }
            return $_COOKIE;

        case 1; //get cookie
            $cookieVarName = ck_name(func_get_arg(0));
            //d('getcookie:', $cookieVarName, @$_COOKIE[$cookieVarName]);
            $cookieVarValue = null;
            if (ckHas($cookieVarName)) {
                $cookieVarValue =  jsonTryDecode($_COOKIE[$cookieVarName]);
            }
            return  $cookieVarValue;

        case 2; //set cookie
            $cookieVarName = ck_name(func_get_arg(0));
            $valueToSet = func_get_arg(1);
            if (is_mixed($valueToSet)) {
                $valueToSet = json_encode($valueToSet);
            }
            //d('setcookie:', $cookieVarName, $valueToSet);
            setcookie($cookieVarName, $valueToSet);
            $_COOKIE[$cookieVarName] = $valueToSet;
            return $valueToSet;


        case 3; //set cookie with ctx
            //[td]
            $cookieVarName = ck_name(func_get_arg(0));
            $valueToSet = func_get_arg(1);
	        if (is_mixed($valueToSet)) {
		        $valueToSet = json_encode($valueToSet);
	        }

            //[oo http://php.net/manual/ru/function.setcookie.php]
			/*
			    n: по умолчанию
			    path это url - на какой страницы ставиться кука
			    expires - ставиться задним числом 1969
			*/
            $ckCtx = func_get_arg(2);
            if ($ckCtx === true) {
	            $ckCtx = array('path' => true);
            }

            //дата окончания действия cookie [df до конца сессии]
            $expiresValue = prop($ckCtx, array(0, 'expires'), 0);
            //путь, для которого cookie действительно [df документ, в котором значение было установлено]
            $pathValue = prop($ckCtx, array(1, 'path'), '');
            if ($pathValue === true) $pathValue = pageDir;
            //домен, для которого cookie действительно [df домен, в котором значение было установлено]
            $domainValue = prop($ckCtx, array(2, 'domain'), '');
            //логическое значение, показывающее требуется ли защищенная передача значения cookie
            $securyValue = prop($ckCtx, array(3, 'secure'), false);
            //
            $httponlyValue = prop($ckCtx, array(4, 'httponly'), false);

			//d($cookieVarName, $valueToSet, $expiresValue, $pathValue, $domainValue, $securyValue, $httponlyValue);
            setcookie($cookieVarName, $valueToSet, $expiresValue, $pathValue, $domainValue, $securyValue, $httponlyValue);
            //setrawcookie
            $_COOKIE[$cookieVarName] = $valueToSet;
            return $valueToSet;
    }

}

function ckHas($cookieVarName){
    return array_key_exists($cookieVarName, $_COOKIE);
    # https://stackoverflow.com/questions/3210935/difference-between-isset-and-array-key-exists#3210982
}


function ckVal($cookieVarName, $otherwise = null){
	return ckHas($cookieVarName) ? ck($cookieVarName) : $otherwise;
}

function ckDel($cookieVarName) {
	if ($cookieVarName === true) {
		//case: clean all cookies
		foreach (ck() as $cookieName => $coockeVal) {
			ckDel($cookieName);
		}
		return true; //count($_COOKIE) === 0
	} else if (ckHas($cookieVarName)) {
        //https://stackoverflow.com/questions/686155/remove-a-cookie#686166
        setcookie($cookieVarName, '', time() - 3600);
        unset($_COOKIE[$cookieVarName]);
        return true;
    } else {
        return false;
    }
}
/*
    http://www.codenet.ru/webmast/php/cookies.php
    http://php.net/manual/ru/function.setcookie.php

-   -   -   - [eg]

_needphp('ck'); $ck = ck(URI); if (!is_numeric($ck)) $ck = 1; ck(URI, ++$ck);



*/


