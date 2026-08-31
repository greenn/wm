<?#1.0
/*  //генератор сниппетов
    [eg
        web/inc/ghtml.inc
            web/test/web/inc/ghtml/test.php
    ]
    [oo
        web/inc/css/pcss.php
        web/inc/js/gjs.php
    ]
*/


_needphp('headers');
_needphp('useTemplate', 'set');

//need PHP 5.3
//static:: //http://php.net/manual/ru/language.oop5.late-static-bindings.php

class gs { //gs|GS|
    static $pattern_noPath = '';
    static $pattern_noResult = '';
    static $pattern_emptyResult = '';
    static $pattern_path = array();

    static function path($name, $type = true, $pattern = null){
        if (!$pattern) {
            $pattern = $type === true
                ? reset(static::$pattern_path) //first item value from stack
                : prop(static::$pattern_path, $type, '');
        }
        $path = sprintf($pattern, $name); //, $type
        $res = !empty($path) ? realpath($path) : false;
        //d($path, is_file($path), is_file($res));
        return $res;
    }

    static function get_path($name){
        $path = false;
        $stack = static::$pattern_path;
        reset($stack);
        while ($pattern = current($stack)) {
            $path = static::path($name, false, $pattern);
            if ($path) break; else next($stack);
        }
        return $path;
    }
    static function create($name/*, $snippets_args */){
        if ($path = static::get_path($name)) {
            $args = func_get_args();
            $res = static::_build($path, $args);
            //dx($path, $res, $args);
            if (!$res) $res = sprintf(is_string($res) ? static::$pattern_emptyResult : static::$pattern_noResult, $name);
        } else {
            $res = sprintf(static::$pattern_noPath, $name);
        }


        return $res;
    }
    static function _build($path, $args){
        $res = useTemplate($path, array('arg' => $args));
        return $res;
    }

    static function get(){} //get|g[gh::g()]|

    static function g(){ //generate / get //0
        $args = func_get_args();
        return call_user_func_array(array('gh', 'create'), $args);
    }


    /*
        получение контекста по сниппету для использования в etag
        [eg  gh::etag('name', 'some', 'extra', 'args', true); ]
    */
    static function etag_ctx(){
        $args = func_get_args();
        $ctx = static::etag_ctx_handle($args);
        return etag::ctxArg($ctx);
    }

    static function etag_ctx_handle($args = array(), $set = false){
        $ctx = array();
        foreach ($args as $name) {
            if (is_array($name)) { //case: передана аrray-конф сниппета, для обработки, например array('snip', $param1)
                $ctx = array_merge($ctx, static::etag_ctx_arr($name));
            }
            else if (is_string($name)) {
                if (is_file($name)) { //case: строка передана сразу как путь до файла, учитываем его
                    $ctx []= $name;
                } else { //case: передано имя сниппета, для обработки
                    $ctx = array_merge($ctx, static::etag_ctx_name($name));
                }
            }
        }
        return array_unique($ctx, SORT_REGULAR);
    }

    //case: спользование имени c доп параметрами
    //первый параметр, как имя снипета, все последующие как данные для etag::extra
    static function etag_ctx_arr($arr){ //case: array('tpl-name', $var, $flag)
        $nameArr = array_splice($arr, 0, 1);
        $ctx = static::etag_ctx_handle($nameArr); //$nameArr = array($name)
        if (!$ctx) { //case: $name не было именем сниппета
            array_unshift($arr, $ctx); //возвращаем его обратно на первое место
        }
        if (!empty($arr)) {
            $ctx []= call_user_func_array(array('etag', 'extra'), $arr);
            //[ne  $ctx []= etag::extra($sub_args); ]
        }
        return $ctx;
    }

    //case: получение etag-контекста для имени
    static function etag_ctx_name($name){
        $ctx = array();
        //проверяем все паттерны на совпадение
        // при нахождение добавляем путь,
        // и так же если есть добавляем зависимости {$relCtx}
        foreach (static::$pattern_path as $type => $pattern) {
            if ($path = static::path($name, $type)) {
                $ctx []= $path; //aka etag::file($path)
                if ($relCtx = static::etag_rel_ctx($name, $type)) {
                    $ctx = array_merge($ctx, $relCtx);
                }
            }
        }
        return array_unique($ctx, SORT_REGULAR);
    }

    static $name_rel = array();

    static function etag_rel_ctx($name, $type = false){
        $res = false;
        if ($rel = prop(static::$name_rel, $name)) {
            if (!is_array($rel)) $rel = array($rel);
            $res = static::etag_ctx_handle($rel);
        }
        return $res;
    }



}