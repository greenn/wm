<?
class blankRm extends rt {
    static $rClass = 'blankRm';
    static $temp;
}

class _blankRm extends _rt {
    static $rClass = 'blankRm';
    static $db = array();
    static $cache = array();

    static function rDir(){
        return dirname(__FILE__).'/r';
    }

    static function className($name){
        return 'blankRm_'.$name;
    }
}

function blankRm($name, $method = null){
    return _r_('blankRm', func_get_args());
}

function blankRmTpl($name, $tplName = true, $tplCtx = false, $fileExt = 'tpl.php'){
    if ($tplName === true) $tplName = $name;
    return blankRm($name, 'tpl', $tplName, $tplCtx, $fileExt);
}
