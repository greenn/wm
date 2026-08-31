<?#0.4

/*
    отодвигает все строки на определеную велечину, относительно опций
    eg[
        set_indent('str', 1, 0); //все строки кроме первой сдвинуть на 4-пробела
        set_indent('str', 1, "\t"); //все строки сдвинуть на один-таб
        set_indent('str', array(0, 1), "  "); //все строки, кроме первой сдвинуть на два-пробела
    ]
*/
function set_indent($string, $indentEach = 1, $opts = true){
    if (is_string($opts)) $opts = array('pad' => $opts);
    else if (is_integer($opts)) $opts = array('indentFirst' => $opts);
    else if (!is_array($opts)) $opts = array();
    if (is_array($indentEach)) {
        $opts['indentFirst'] = $indentEach[0];
        $indentEach = $indentEach[1];
    }
    $opts = array_replace(array(
        'indentFirst' => $indentEach,
        'lineSep' => "\r\n", //PHP_EOL
        'pad' => str_repeat(' ', 4),
    ), $opts);

    $sep = $opts['lineSep'];
    $pad = $opts['pad'];
    $k0 = $opts['indentFirst'];
    $k = $indentEach;

    $lines = explode($sep, $string); //d($lines);
    $indent = str_repeat($pad, $k0);
    $res = $indent.array_shift($lines);
    foreach ($lines as $line) {
        $indent = str_repeat($pad, $k);
        $res .= $sep.$indent.$line;
    }
    return $res;
}

//уменьшает много-строковый текст, на общий минимальный отступ текста от начала строки
function reduce_min_indent($val, $skipFirstLine = true){

    if (is_string($val)) {
        $sep = "\r\n"; //PHP_EOL

        if (is_integer(strpos($val, $sep))) {
            $lines = explode($sep, $val); //d($lines);
            $val = '';
            if ($skipFirstLine) { //(первую строку не учитываем)
                $val = array_shift($lines) . $sep;
            }


            $spaces = array(); //кол-во пробелов в начале каждой строки
            $tSize = 4;
            //проходимся по каждой строке,
            // ищем табы и пробелы в начале строк,
            // считаем их размер
            // заносим в массив $spaces
            foreach ($lines as $index => $line) {
                $t = '([\t]+)';
                $s = '([ ]+)';
                preg_match_all("~^($t|$s)~m", $line, $matches, PREG_SET_ORDER);
                $spaces[$index] = 0;
                if ($matches && ($match = $matches[0])) {
                    //d($matches, $match);
                    if ($match[2]) { //case: табы в начале строки
                        //d('табы2', $line, strlen($match[1]));
                        $spaces[$index] = strlen($match[1]) * $tSize;
                    } elseif ($match[3]) { //case: пробелы в начале строки
                        //d('пробелы1', $line, strlen($match[1]));
                        $spaces[$index] = strlen($match[1]);
                    }
                }
            }

            //если есть минимальное значение больше нуля
            //заменяем пробелы и табы в каждой строке, на уменьшенное кол-во пробелов
            //dx($spaces, min($spaces));
            if ($reduce = min($spaces)) {
                foreach ($spaces as $index => $n) {
                    $lines[$index] = preg_replace('~^[ \t]+~', str_repeat(' ', $n - $reduce), $lines[$index]);
                }
            }

            $val .= join($lines, $sep);

        } elseif (!$skipFirstLine){
            $val = ltrim($val, ' \t');
        }
    }
    return $val;
}