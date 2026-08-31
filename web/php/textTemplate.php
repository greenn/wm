<?#0.1
/*

    [oo web/js/web/js/helpers/str_.js.inc::textTemplate()]
    [oo web/php/response.php::msg()/msg_callback()]
    [oo web/php/w.php::setQCases()]
    [eg web/test/php/textTemplate/index.php
        textTemplate('%t|u%', $ctx),
        textTemplate('%t|c%', $ctx),
        textTemplate('ну нету у нас %t|rr|f%', $ctx)
        //[td-ff] textTemplate('ну нету у нас %t|w/rr/5/U|f%', $ctx)
    ]
*/
_needphp('set', 'w');

function textTemplate($pattern, $ctx = false, $opts = null){
    $defOpts = array('patternClass' => 'text_pattern');
    $set = set($defOpts, $opts);
    $class = $set->patternClass;

    $strPattern = new $class();
    return $strPattern::apply($pattern, $ctx, $set);
}

class text_pattern {
    static $regex = '~%([^%]+)%~'; //рега для паттерна
        //https://regex101.com/r/hav7Y1/1/
    static $ml = '|'; //разделитель для модификаторов
    static $mdf_regex = '\(([^)]+)\~'; //рега для суб-модификаторов




    static $ctx = null; //temp
    static function ctx(){
        return is_array(static::$ctx) ? static::$ctx : array();
    }
    static $set = null; //temp
    static function set(){
        return is_set(static::$set) ? static::$set : set();
    }
    static function apply($pattern, $ctx = null, $opts) {
        $set = set($opts);
        static::$ctx = $ctx;
        static::$set = $set;
        $res = self::replace($pattern);
        static::$ctx = null;
        static::$set = null;
        //dx($res, $pattern, $ctx, $set);
        return $res;
    }
    static function replace($pattern) {
        $res = preg_replace_callback(static::$regex, 'static::replace_callback', $pattern); //dx($res);;
        return $res;
    }
    static function replace_callback($match) {
        $ctx = static::ctx();
        $key = $match[1]; //substr($match[1], 1, -1);

        $mdf = false;
        if (strpos($key, static::$ml) !== false) {
            $mdf = explode(static::$ml, $key);
            $key = array_shift($mdf);
        }

        $swap = prop($ctx, $key, $key);

        if ($mdf) {
            $swap = static::mdf($swap, $mdf);
        }

        return $swap;
    }

    static function mdf($str, $mdf) {
        if (!is_array($mdf)) $mdf = array($mdf);
        foreach ($mdf as $mdfName) {
            $str = static::use_mdf($mdfName, $str);
        }
        return $str;
    }

    static function use_mdf($mdf, $str) {
        $res = $str;
        $set = static::set();
        $mdfSub = null; //[td использовать $mdf_regex для парсинга суб-модикаторов в $mdf]
        $mdfName = $mdf; //[td использовать $mdf_regex для парсинга суб-модикаторов в $mdf]
        $mdfHandler = "static::mdf_$mdfName";
        //dx($mdfName, is_callable($mdfHandler), $mdf);

        $mdf_res = null;
        if (is_callable($mdfHandler)) {
            $mdf_res = call_user_func($mdfHandler, $str, $mdfSub);
        } elseif ($mdfName = prop(wordCase::$vcases, $mdfName)){
            //if (static::$set->use_w);
            $mdf_res = w($str, $mdfName);
        }

        if (is_string($mdf_res)) $res = $mdf_res;
        //else case: если {handler} вернул не-строку {eg void} - то строку не меняем


        return $res;
    }


    static function mdf_u($str){ //все буквы в верхний регистр
        return word::m_u($str);
    }

    static function mdf_s($str){ //все буквы в нижний регистр
        return word::m_s($str);
    }

    static function mdf_c($str){ //все слова с большой буквы
        return word::m_c($str);
    }

    static function mdf_f($str){ //первое слова с большой буквы
        return word::m_f($str);
    }

    static function mdf_sb($str){ //пробел перед, если есть значение
        return $str ? " $str" : '';
    }
}