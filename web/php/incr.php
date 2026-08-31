<?#3.22

//incr(null, $name) - возвращает текущее значение или 0 по имени
function incr($name = false, $withName = false, $nameGlue = ''){
    static $stack = array();

    //case: add-functionality
    if (is_null($name)) {
        return isset($stack[$withName]) ? $stack[$withName] : 0;
    }

    if (!$name) {
        $name = php('cacheCaller');
    }

    if (!isset($stack[$name])) {
        $stack[$name] = 0;
    }

    $res = ++$stack[$name];
    return $withName ? $name.$nameGlue.$res : $res;
}
