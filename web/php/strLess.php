<? #5.1.1
//допускается

/*
	eg
		dx($URI = $_SERVER['REQUEST_URI'], strLess($URI, '\?.*', true, true));
*/
function strLess($fullString, $trimString, $fromEnd = false, $isPattern = false){
	$startPattern = $isPattern ? $trimString : preg_quote($trimString); 
		
	$regas = array(
        //'~^'.preg_quote(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'])).'~',
        //'~^'.preg_quote(str_replace('/', '\\', $_SERVER['DOCUMENT_ROOT'])).'~'
        $fromEnd ? "~$startPattern$~" : "~^$startPattern~"
    );

    $resString = preg_replace($regas, '', $fullString);

    //d($fromEnd, $fullString, $trimString, $regas, $resString);

    return $resString;
}

//
function pathLess($fullString, $lessString){
    $regas = array(
        '~^'.preg_quote(str_replace('\\', '/', $lessString)).'~',
        '~^'.preg_quote(str_replace('/', '\\', $lessString)).'~'
    );

    $resPath = preg_replace($regas, '', $fullString);

    return $resPath;
}

function strTrim($lessStart, $string, $lessEnd) {
    return strLess(strLess($string, $lessStart), $lessEnd, true);
}


/* * /
function extLess($path){
    $regas = array(
        //
    );

    $resString = preg_replace($regas, '', $path);

    return $resString;
}
/**/