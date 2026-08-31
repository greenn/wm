<?#0.2
// про url

//_needphp('set');
_needphp('isAssoc');

//простой объект для url
//для более узкой работы [oo urlToken / turl]
//[eg web/test/web/inc/url.php]
class url { //[ak qurl]

    //приведение данных к массиву{ao} из строк - пар значений, типа url-query - param=value
    // возможность соединять несколько
    // без поиска дубликатов
	// переданная строка не распарсивается
    static function q_ar($q/*, more $q*/){
    	//d($args0 = func_get_args(), func_num_args());
	    $args = func_get_args();

        if (func_num_args() > 1) {// step: list-mode
            $q = array();
            //$args = func_get_args(); //d($args, $args0); //PZ
            foreach ($args as $qa) {
            	//dx($qa);
                $qn = static::q_ar($qa);
                $q = array_merge($q, $qn);
                //d($qn, $q);
            }
        } else { // step: item-mode
            $q = is_string($q) ? array($q) : (is_array($q) ? $q : array());
            if (isAssoc($q)) {
                $_t = array();
                foreach ($q as $name => $val) {
                    $_t []= is_null($val) ? $name : "$name=$val";
                }
                $q = $_t;
            }
        }
        return $q; //{aa}
    }
    static function q_ar0($args, $slice = 0) {
        if ($slice) $args = array_slice($args, $slice);
        return call_user_func_array('url::q_ar', $args);
    }


    //разделить строку на uri и query
    static function q_split($uri){
        $query = false;
        if (strpos($uri, '?') !== false) {
            list($uri, $query) = explode('?', $uri, 2);
        }
        return array($uri, $query);
    }

    //расширить строку query-параметрами
    static function q_ext($str, $q/*, more $q*/){ //q_ext
        if ($q = static::q_ar0(func_get_args(), 1)) {
        	//d($q);
            list($str, $qs) = static::q_split($str);
            if ($qs) array_unshift($q, $qs);
            if ($q) $str .= "?" . join('&', $q);
        }
        //d(func_get_args(), $str);
        return $str;
    }

}