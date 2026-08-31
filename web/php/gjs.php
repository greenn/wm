<?#1.2.0

//генератор js-сниппетов

define('GJS_PATTERN_HANDLER', PHP.'/gjs/tpl/%s.inc');
define('GJS_PATTERN_TPL', PHP.'/gjs/tpl/%s.js.inc');


_needphp('useTemplate');
_needphp('str_indent');

function gjs_path($name, $tpl = false) {
    return realpath(sprintf($tpl ? GJS_PATTERN_TPL : GJS_PATTERN_HANDLER, $name));
}

function gjs_has($name, $tpl = false) {
    return is_file(gjs_path($name, $tpl));
}

function gjs($name){
    $args = func_get_args();
    //$addNewLine = false;
    //if (is_bool($name)) $addNewLine = array_shift($args);
    //$name = $args[0];
    $path = $_handler = gjs_path($name);
    if (!$path) $path = $_tpl = gjs_path($name, true);

    $res = $path ? useTemplate($path, array('arg' => $args)) : ";'$name';";

    //if ($addNewLine) $res .= "\r\n"; PHP_EOL;
    return $res;
}
function _gjs(){
    return '';
}


function gjs_if($state){
    $args = func_get_args();
    array_shift($args);
    return $state ? call_user_func_array('gjs', $args) : '';
}

function gjs_replace($tpl, $replacements){
    $patterns = array(); //inclusion|entries|patterns|
    $substitutions = array(); //substitutions|
    foreach ($replacements as $string => $change) {
        $patterns []= sprintf('/\b%s\b/', preg_quote($string));
        $substitutions []= $change;
    }
    $result = preg_replace($patterns, $substitutions, $tpl);
    return $result;
}

//вызов gjs со сдвигом всего содержимого на n-раз пробельным tab`ом
/*[eg
    gjs_(array(1,1), true, $name) - добавить в gjs($name) отступ в самом конец b для всех строк
    gjs_(2, $name) - двойной отступ для всех строк
]*/
function gjs_($indent, $name){
    $args = func_get_args();
    $indent = array_shift($args);

    $addNewLine = false;
    if (is_bool($name)) $addNewLine = array_shift($args);

    $tpl = call_user_func_array('gjs', $args);

    if (!is_array($indent)) $indent = array(0, $indent);
    $tpl = set_indent($tpl, $indent);

    if ($addNewLine) $tpl .= "\r\n"; PHP_EOL;
    return $tpl;
}
function _gjs_(){
    return '';
}

_needphp('headers');
function gjs_etag_ctx(){
    $args = func_get_args();
    $ctx = array();
    foreach ($args as $name) {
        if (is_array($name)) {
            $ctx []= call_user_func_array(array('etag', 'extra'), array_splice($name, 1));
            //$ctx []= etag::extra(array_splice($name, 1));
            $name = $name[0];
        }
        if (is_file($handler = gjs_path($name))) {
            $ctx []= $handler;
        }
        if (is_file($tpl = gjs_path($name, true))) {
            $ctx []= $tpl;
        }
    }
    return etag::ctxArg($ctx);
}

//function gjs_reduce_indent(){}
//function gjs_increase_indent(){}
//function gjs_set_indent($str, $indentSet, $indentPad){}