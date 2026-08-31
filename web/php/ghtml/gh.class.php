<?#0.8.0
/*  //генератор html-сниппетов
    [eg web/test/web/inc/ghtml/test.php]
*/

_needphp('ghtml/gs');

class gh extends gs {
    static $pattern_noPath = '{-gh:%s}';
    static $pattern_noResult = '{~gh:%s}';
    static $pattern_path = array();

    static $name_rel = array(
        'ko-tp-dbg/buttons' => array('ko-tp-dbg/button'),
        'ko-tp-dbg/li-buttons' => array('ko-tp-dbg/buttons'),
    );

    static function etag_ctx_arr($arr){
        $res = array();
        $name = prop($arr, 0);
        if ($name === 0) $name = false; //[bg switch(0)]
        switch ($name) {
            case 'ko-tp-dbg/li-items': { //case: array('ko-tp-dbg/li-items', array('value', 'input''))
                /*[bg switch(0)]*///dx('почему срабатывает case 0 здесь -а-а-а-а-)', $name);
                if ($relItems = prop($arr, 1)) {
                    $ctx = array();
                    foreach ($relItems as $name) {
                        $ctx []= "ko-tp-dbg/li-$name";
                    }
                    $res = static::etag_ctx_handle($ctx);
                }
            } break;
            case 0: default: {
                $res = parent::etag_ctx_arr($arr);
            }
        }
        return $res;
    }


}
gh::$pattern_path = array(
    'handler' => INC.'/ghtml/s/%s.php',
    'snippet' => INC.'/ghtml/s/%s.inc',
    'tpl' => INC.'/ghtml/s/%s.tpl',
);


function _gh(){
    return '';
}

/*
    [eg
        gh(0, $args) - использовать $args как стек аргументов при gh::create(), т.е. gh::create($a, r, g, s)
        gh(1, $name, $args) - использовать $args как стек аргументов с предваряющим $name при gh::create(), т.е. gh::create($name, $a, r, g, s)
    ]
*/
function gh($set){
    $args = func_get_args();
    if (!is_string($set)) {
        $set = gh_opt(array_shift($args));
        if ($set->nameIsCtx) { //case: gh(0, $args)
            $args = $args[0];
        } elseif ($set->firstArgIsCtx) { //case: gh(1, $name, $args)
            $name = $args[0];
            $args = $args[1];
            array_unshift($args, $name);
        }
    }
    return call_user_func_array(array('gh', 'create'), $args);
}
function gh_opt($idn = null) {
    $set = set();
    if (func_num_args()) {
        if (is_array($idn) && count($idn) === 1) $idn = $idn[0];
        if (is_stringable($idn)) switch ($idn) {
            case 0: {
                $set->nameIsCtx = true;
            } break;
            case 1: {
                $set->firstArgIsCtx = true;
            } break;
        }
    }
    return $set;
}