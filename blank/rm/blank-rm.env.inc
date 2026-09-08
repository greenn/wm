<?
class blankRm extends rt {
    static $rClass = 'blankRm';
    static $temp = array();
}

class _blankRm extends _rt {
    static $rClass = 'blankRm';
    static $db = array();
    static $cache = array();

    static function rDir(){
        return __DIR__.'/r';
    }

    static function className($name){
        return 'blankRm_'.$name;
    }
}

function blankRm($name, $method = null){
    return _r_('blankRm', func_get_args());
}

function blankRmTpl($name, $tplName, $tplCtx = false, $fileExt = 'tpl.php'){
    return _r_tpl('blankRm', func_get_args());
}
