<?//1-12
//lazy cache
//rename to lc

function cacheCaller(){
    $phpCallStack = debug_backtrace();
    $callerInfo = array_pop($phpCallStack);
    $caller = $callerInfo['function'];
    if ($caller === 'cache')
        $caller = $callerInfo['file'];
    return $caller;
}

function cached($dataId){
    if (!is_string($dataId) && !is_numeric($dataId)) {
        $dataId = serialize($dataId);
    }
    $section = cacheCaller();
    return cache($section, $dataId, 'has');

}
function cache(/*$sectionName, $valueToSet*/){
    static $cache = array();

    switch (func_num_args()) {
        case 0;
            $section = cacheCaller();

            return isset($cache[$section]) ? $cache[$section] : null;

        case 1;
            $res = null;

            $section = cacheCaller();

            if (isset($cache[$section])) {
                $sectionId = func_get_arg(0);
                if (!is_string($sectionId) && !is_numeric($sectionId)) {
                    $sectionId = serialize($sectionId);
                }

                if (isset($cache[$section][$sectionId]))
                    $res = $cache[$section][$sectionId];
            }

            return  $res;

        case 2;
            $section = cacheCaller();

            if (isset($cache[$section]))
                $cache[$section] = array();

            $sectionRes = func_get_arg(1);

            $sectionId = func_get_arg(0);
            if (!is_string($sectionId) && !is_numeric($sectionId)) {
                $sectionId = serialize($sectionId);
            }

            $cache[$section][$sectionId] = $sectionRes;
            return $sectionRes;

        case 3;

            $optionName = func_get_arg(2);
            $option = func_get_arg(1);
            $section = func_get_arg(0);

            switch($optionName) {
                case 'has';
                    return isset($cache[$section]) && isset($cache[$section][$option]);

                case 'self';
                    switch ($option) {
                        case 'size';
                    }
                    return $cache;
            }

    }
}

//5 incr
function cacheCountInc($counterName = false){
    static $cacheCounter = array();

    if ($counterName) {
        $counterName = cacheCaller();
    }

    if (!isset($cacheCounter[$counterName]))
        $cacheCounter[$counterName] = 1;

    return $cacheCounter[$counterName]++;
}