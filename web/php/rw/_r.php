<?#0.9.15 - r call-manager



/*
_draft::reg('blank', array());
_r('draft', 'reg', 'blank', array());
*/
function _r($rClass, $method/*, $arg1, $arg2*/){
	$args = array_slice(func_get_args(), 2);
	$handler = array($rClass, $method);
	//$handler = "$rClass::$method";
	///$handler = $rClass::$method;
	return call_user_func_array($handler, $args);
}


//ak r_apply | apply_r
function r_($rClass, $rName, $rMethod = null/*, $arg1, $arg2*/){
	//dx($rClass, $rName, $rMethod, func_get_arg(3), func_get_arg(4));
	//dx($rClass, $rName, call_user_func(array('_'.$rClass, 'name'), $rName));
	//dx(1, array('_'.$rClass, 'name'), $rName);

	//dx($rClass, class_exists('_'.$rClass), method_exists('_'.$rClass, 'name'));

	$R = call_user_func(array('_'.$rClass, 'name'), $rName);
	//q-ak _r($rClass, 'name', $rName)
	//d($rName, $R);

	if ($R) {
		if (!$rMethod) return $R;
		$args = array_slice(func_get_args(), 3); //минус $rClass, $rName и $rMethod
		//dx($R, $rMethod, $args);
		return call_user_func_array(array($R, $rMethod), $args);
	}
}

//гормон:
//  запускат r_ аргументами
//  аргументирует r_ аргументом
function r__($Args){
	$rClass = $Args[0];
	//d($rClass, is_callable($rClass), $Args);
	if (is_callable($rClass)) {
		return call_user_func_array('r_', $Args);
	}
}

function _r_($rClass, $Args){
	array_unshift($Args, $rClass);
	//dx($rClass, func_get_arg(1), $Args);
	return r__($Args);
}


function _r_tpl($rClass, $Args){
	array_splice($Args, 1, 0, array('tpl')); //после $rName
	//dx($rClass, $Args);
	return _r_($rClass, $Args);
}

function _r_tpl_($rClass/*, $A, $r, $g, $s*/){
	$Args = array_slice(func_get_args(), 1);
	//dx($Args);
	return _r_tpl($rClass, $Args);
}


/*
	function _r_tpl($rClass, $Args){
		array_unshift($Args, $rClass);
		array_splice($Args, 2, 0, array('tpl')); //после $rClass, $rName
		return r__($Args);
	}
*/


	//ak = r_
	function r($rClass, $name, $method = null/*, $arg1, $arg2*/){
		return r__(func_get_args());
	}

//ak ~ _r_tpl / ak r_tpliq/config/.dev/re/l-stats
function tpl($rClass, $name, $tplName = true, $tplCtx = false, $fileExt = 'tpl.php'){
	//return _r_tpl('site', func_get_args());
	if (is_array($tplName)) {
		//case: site_tpl($name, $tplCtx)
		$tplCtx = $tplName;
		$tplName = true;
	}
	if ($tplName === true) {
		//case: site_tpl($name)
		$tplName = $name;
	}
	//dx($rClass, $name, $method = 'tpl', $tplName, $tplCtx, $fileExt);
	return r($rClass, $name, 'tpl', $tplName, $tplCtx, $fileExt);
}

//01
function tpl_($Args) {
	return call_user_func_array('tpl', (array)$Args);
}





/*
	usage
		function rt($name, $method = null/*, $arg1, $arg2* /){
			if ($R = _rt::name($name)) {
				$args = array_slice(func_get_args(), 2);
				return call_user_func_array(array($R, $method), $args);
			}
		}


	function rv($name, $method = null/*, $arg1, $arg2* /){
		$args = func_get_args();
		array_unshift($args, 'rv');
		return r__($args);
	}
	//==
	function rv($name, $method = null/*, $arg1, $arg2* /){
		return _r_('rv', func_get_args());
	}


		function rv_tpl($name, $tplName, $tplCtx = false, $fileExt = 'tpl.php'){
			return rv($name, 'tpl', $tplName, $tplCtx, $fileExt);
		}
	function rv_tpl($name, $tplName, $tplCtx = false, $fileExt = 'tpl.php'){
		$args = func_get_args();
		array_splice($args, 2, 0, array('tpl')); //после $rClass, $rName
		return r__($args);
	}
	//==
	function rv_tpl($name, $tplName, $tplCtx = false, $fileExt = 'tpl.php'){
		return _r_tpl('rv', func_get_args());
	}

*/