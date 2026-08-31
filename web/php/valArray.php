<?//6-17

//[tm]
function valArray($array, $nameProp = 0){
    static $catch = array();
    $res = isset($array[$nameProp]) ? $array[$nameProp] : $nameProp;

    $hasSub = (is_string($res) || is_numeric($res)) && isset($array[$res]);
    if ($hasSub && !isset($catch[$res])) {
        $catch[$res] = 1;
        $res = call_user_func(__FUNCTION__, $array, $res);
    } else {
        $catch = array();
        if ($hasSub)
            $res = $array[$res];
    }

    return $res;
}

function valArrayMap($array){ //mapValArray
    foreach ($array as $n => &$v) {
        $v = is_array($v) ? valArrayMap($v) : valArray($array, $n);
    }
    return $array;
}

/*
    oo web/test/web/php/valArrayMap.php
	eg
        valArray(array(
            '0' => '1',
            '1' => 2
        )); // == 2

    >>
        arrayVal
*/