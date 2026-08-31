<?#4.16.3

function g(/*$globalVarName, $valueToSet*/){
	/*if (func_get_arg(0) === 'preventHeaders') {
		d('preventHeaders', func_num_args() == 2 ? func_get_arg(1) : null);
	}*/

    if (func_num_args() == 0) {
        return $GLOBALS;
    } else if (func_num_args() == 1) {
        $globalVarName = func_get_arg(0);
        //d0('g:has', $globalVarName);
        return gHas($globalVarName) ? $GLOBALS[$globalVarName] : null;
    } else if (func_num_args() == 2) {
        $globalVarName = func_get_arg(0);
        $valueToSet = func_get_arg(1);
	    //d0('g:set', $globalVarName, $valueToSet);
        $GLOBALS[$globalVarName] = $valueToSet;
        return $valueToSet;
    }
}

function gHas($globalVarName){
    return array_key_exists($globalVarName, $GLOBALS);
}

function gDel($globalVarName) {
    if (gHas($globalVarName)) {
        unset ($GLOBALS[$globalVarName]);
        return true;
    } else {
        return false;
    }
}

function gIncr($varName){
	$value = gHas($varName) ? g($varName) : 0;
	return g($varName, ++$value);
}
function gDecr($varName){
	$value = gHas($varName) ? g($varName) : 0;
	return g($varName, --$value);
}

/*
    plans:

    (func_num_args() > 2) {
    $flagClone =  func_get_arg(2); //via serialize

    gs
        as global-settings


*/