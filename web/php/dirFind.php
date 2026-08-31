<?#1.0.14

/*ищем файл по параметрам
    $value - значение, которое используем в поиске
    $type - тип
        filename
        ext
    $dir - директория
        путь
        true - тогда берётся директория вызова
        array - структура директории из dirToArray
    $depth - глубина поиска в директории
        пока не учитывается если сразу передана структура
    $set - настройки

        [ff] return - значение резульата
            path [df]
            filename [df]
            basename - без расширения
        [ff] multi - искать все значения (не для dirFindFirst)
        [ff] returnAll
        [ff] returnFirst

*/
function dirFindFirst($value, $type = 'filename', $dir = true, $depth = 0, $set = array()) { //dirFind|dirFindFirst|
    $found = null;

    $dirData = null;
    if (is_array($dir)) $dirData = $dir;
    else {
        if ($dir === true) $dir = php('getCaller', 'dir');
        $dirData = php('dirToArray', $dir, $depth);
    }

    if ($dirData) {

        switch ($type) {
            case 'ext': {
                $regex_value = preg_quote($value);
                foreach ($dirData as $name => $path) {
                    if (preg_match("~\.$regex_value$~", $name)) {
                        $found = $path;
                        break;
                    }
                }
            } break;

            case 'filename': {
                foreach ($dirData as $name => $path) {
                    if ($name === $value) {
                        $found = $path;
                        break;
                    }
                }
            } break;
        }

    }

    return $found;
}