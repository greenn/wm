<?#1.5.3 L

/*
	oo
		web/test/web/php/x/x_shift.php
	rb
			via xvar|svar|gvar|sv
		static class x::
*/

//_addphp('x/x_'); >> xvar


function x(){
    static $ctx = array();

    if (0) {
	    $debug = 'contentTitle';
	    if (($v = func_num_args()) && func_get_arg(0) === $debug) {
		    d($debug, $v, prop($ctx, $debug));
	    }
    }


    switch (func_num_args()) {
        case 0;
            return $ctx;

        case 1:
            $varName = func_get_arg(0);
            return isset($ctx[$varName]) ? $ctx[$varName] : null;

        case 2:
            $varName = func_get_arg(0);
            $varValue = func_get_arg(1);
            $ctx[$varName] = $varValue;
            return $varValue;

        case 3:
            $varName = func_get_arg(0);
            $funcArg = func_get_arg(1);
            $funcName = func_get_arg(2);

            switch ($funcName) {
                case 'delete': {
                    if (isset($ctx[$varName])) {
                        unset($ctx[$varName]);
                        return true;
                    }
                    return false;
                }
            }
            break;
    }
};

/*
	//установка нескольких значениях, через очерёдость аргументов
	//* нигде не использовалось / можно перезаписывать или удалить
	function _x(){
	    $name = false;
	    for ($i = 0; $i < func_num_args(); $i++) {
	        $arg = func_get_arg($i);
	        if (!$name) {
	            if (is_array($arg) || is_object($arg)) {
	                foreach ($arg as $_name => $_value)
	                    x($_name, $_value);
	            } else {
	                $name = $arg;
	            }
	        } else {
	            x($name, $arg);
	            $name = false;
	        }
	    }
	};
*/

function xd($name){
    return x($name, null, 'delete');
};

function xx(){ //xx|xs|
    $stack = array();
    foreach (func_get_args() as $name) {
        $stack[$name] = x($name);
    }
    return $stack;
}

function x_is($name, $value){
    return x_has($name) && (x($name) === $value);
}

function x_has($name) {
    $ctx = x();
    return isset($ctx[$name]);
}
function x_get($name, $otherwise = null) {
    return x_has($name) ? x($name) : $otherwise;
}

function x_val($name, $otherwise = null) {
	$val = x_get($name);
	if (!$val) $val = $otherwise;
	return $val;
}
function x_prop($name, $prop, $otherwise = null) {
	return prop(x($name), $prop, $otherwise);
}

function x_flush($name, $restValue = null) {
	$hasRest = func_num_args() > 1;
	$x = x($name);
	if (x_has($name)) {
		if ($hasRest) {
			x($name, $restValue);
		} else {
			xd($name);
		}
	}
	return $x;
}

//function x_(){}; //tool >> x.class

function x_set($name, $prop, $value){
    $x = x_has($name) ? (array) x($name) : x($name, array());
    $x[$prop] = $value;
    return x($name, $x);
};

function x_push($name, $value, $prop = null){
    $isAssoc = func_num_args() > 2;

    $x = x($name);

    if (!x_has($name)) {
        $x = array();
    } elseif (!is_array($x)) {//0
        $x = array($x);
        //[mb] $x = array(); //[mb] при опции {%arg4}
    }

    if ($isAssoc) {
        $x[$prop] = $value;
    } else {
        $x []= $value;
    }
    //d($x);
    return x($name, $x);
}

function x_shift($name){
	$x = x($name);
	if (isOrdinal($x)) {
		$res = array_shift($x);
		x($name, $x);
		return $res;
	}
}

function x_pop($name){
	$x = x($name);
	if (isOrdinal($x)) {
		$res = array_pop($x);
		x($name, $x);
		return $res;
	}
}

function x_end($name) {
	$x = x($name);
	if (is_array($x)) {
		return end($x);
	}
	return $x;
}


_addphp('fq/_merge');
function x_merge($name, $arg1/*, $argN*/){
	$args = func_get_args();
	$args[0] = x($name);
	$res = call_user_func_array('merge', $args);
	return x($name, $res);
}
/*
    /web/test/web/php/x.php


*/

/*
//dd = brr uu
function x_add($name, $val, $xType = false){
	if (!$xType) {
		if (is_numeric($xType));
		if (is_stringable($xType));
		if (is_array($xType)) x_push();
	} else switch ($xType) {
		case 'css': $x .= ' '.$val; break;
	}
}
*/
function xc($name = 'counter') {
   static $stack = array();
   if (!isset($stack[$name])) $stack[$name] = 0;
   return ++$stack[$name];
}