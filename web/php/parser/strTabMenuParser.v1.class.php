<?#1.4.2
_needphp('transliterate');

//strTabMenuParser / tabStructPatser
class strTabMenuParser {

    static function parse($struct){
        $list = array();

        $lines = preg_split("/\r\n|\n|\r/", $struct);


        $addr = array(-1);
        $prev_depth = 0;
        foreach ($lines as $line) {
            $item = static::extract($line);

            if ($item['depth'] > $prev_depth) {
                static::_addrDown($addr);
            }
            if ($item['depth'] < $prev_depth) {
                static::_addrUp($addr, $prev_depth - $item['depth']);
            }
            if ($item['depth'] === $prev_depth) {
                static::_addrInc($addr);
            }

            //$dbg = '['. join('.', $addr). ']'. ' '. $item['title']; d($dbg);

            $item['addr'] = join('', $addr);
            static::_addTo($list, $addr, $item);
            $prev_depth = $item['depth'];
        }

        return $list;
    }

    //увеличить адрес на единицу
    static function _addrInc(&$addr){
        $last_key = count($addr) - 1;
        $addr[$last_key] += 1;
    }
    //Вернуться на адресс выше (по глубине)
    static function _addrUp(&$addr, $steps = 1){ //_addrBack|_addrTop|_addrUp
        for ($i = 0; $i < $steps; $i++) {
            array_pop($addr);
        }
        static::_addrInc($addr);
    }
    static function _addrDown(&$addr){ //_addrBack|_addrTop|_addrUp
        $addr []= 0;
    }

    //добавить элемент в стек по адресу
    static function _addTo(&$stack, $addr, $item){
        $rel = &$stack;

        //step: спускаемся внутрь структуры
        $fin_depth = count($addr) - 1;
        $link = array();
        foreach ($addr as $depth => $id) {
            if ($depth === $fin_depth) {
                //step: присваиваем данные по id в полученый стек

                $link []= $item['link'];
                foreach ($link as $key => $val) $link[$key] = trim($val, '/');
                $item['link'] = '/'.join('/', $link);

                $rel[$id] = $item;
            } else {
                //step: переходим в элемент
                $rel = &$rel[$id];
                if ($depth === $fin_depth - 1) $link []= $rel['link'];
                if (!isset($rel['sub'])) $rel['sub'] = array();
                $rel = &$rel['sub'];
            }
        }
    }

    static function fetch($stack, $data){}

    //[eg] Рассылки \ name=trg-par link=notify
    static $optStartSign = '\\';
    static $optItemSep = ' ';
    static $optValSep = '=';
    static $sid = 0;
    static function extract($line){
        preg_match("/^\t+/u", $line, $matches);
        //preg_match("/^\\d*\t+/u", $line, $matches);

        $depth = $matches ? strlen($matches[0]) : 0;

        $title = ltrim($line, "\t");
        //$title = preg_replace('/^\\d*\t+/', '', $line);

        $optsData = '';
        if (strpos($title, static::$optStartSign) !== false) {
            $optsData = strstr($title, static::$optStartSign);
            $optsData = substr_replace($optsData, "", 0, strlen(static::$optStartSign));
            $optsData = trim($optsData);
            $title = strstr($title, static::$optStartSign, true);
        }
        $title = rtrim($title);

        $link = transliterate($title);
        $link = strtolower($link);
        $link = str_replace(' ', '-', $link);
        $link = "/$link";

        $item = array('depth' => $depth, 'title' => $title, 'link' => $link);
        $item['sid'] = static::$sid++;


        if ($optsData) {
            static::_extractOpts($optsData, $item);
        }

        return $item;
    }

    static function _extractOpts($optsData, &$item){
        $opts = explode(static::$optItemSep, $optsData);
        //$item['opts'] = $opts; //dbg

        //d($opts);

        foreach ($opts as $index => $opt) {

            if (strpos($opt, static::$optValSep) !== false) {
                $value = strstr($opt, static::$optValSep);
                $value = substr_replace($value, "", 0, strlen(static::$optValSep));
                $value = trim($value);

                $prop = strstr($opt, static::$optValSep, true);
            } else {
                $prop = $opt;
                $value = true;
            }

            if ($value === 'true') $value = true;
            if ($value === 'false') $value = false;
            if ($value === 'null') $value = null;
            $item[$prop] = $value;

        }
    }

    static function getSubListAs($prop = 'sid', $data){
        $list = array();
        foreach ($data as $item) {
            $list []= $item[$prop];
        }
        return $list;
    }

    static function convertToListBy($prop, $data, $parent = false){
        $list = array();

        foreach ($data as $item) {
            $item['parent'] = $parent;

            if (isset($item['sub']) && $item['sub']) {
                if (!$parent) $parent = array();
                //array_push($parent, $item['sid']);
                array_unshift($parent, $item['sid']);
                $subList = static::convertToListBy($prop, $item['sub'], $parent);

                $list = array_merge($list, $subList);
                $item['sub'] = static::getSubListAs('sid', $item['sub']);
            }



            if (!isset($item[$prop])) continue;
            $key = $item[$prop];
            if (!is_stringable($key)) $key = json_encode($key);
            $list[$key] = $item;

        }
        ksort($list);
        return $list;
    }


}