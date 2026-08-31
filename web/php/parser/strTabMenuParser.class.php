<?#2.2.3
_needphp('transliterate');

//strTabMenuParser / tabStructPatser
class strTabMenuParser {

	static function parse($struct, $format = true){
		$list = array();

		$lines = preg_split("/\r\n|\n|\r/", $struct); //here: разбиваем данные на строки

		static::reset_depth();

		foreach ($lines as $line) {
            $item = static::extract($line);
            $list []= $item;
		}

        if ($format) {
            $list = static::formatByAddr($list);
        }

		return $list;
	}

    static function formatByAddr($data){
        $list = array();
        foreach ($data as $item) {
            $addr = prop($item, '-addr');
            //d($item, $addr);
            if ($addr) {
                static::_addTo($list, $addr, $item);
                unset($item['-addr']);
            }
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
        $item = static::extract_spec($line);
        if (!$item) {

            $item = static::extract_base($line);
            //d($line, $item);
            static::_handle_addr($item);
            static::_handle_link($item);
            static::_handle_name($item);
        }
        //d($item);
        return $item;
    }

    static function extract_spec($line){
        $item = false;
        if (!trim($line)) {
            $item = array(
                'spec-type' => 'empty-line'
            );
        }
        return $item;
    }

	static function extract_base($line){
		preg_match("/^\t+/u", $line, $matches);
		//preg_match("/^\\d*\t+/u", $line, $matches);

        $depth = $matches ? strlen($matches[0]) : 0; //кол-во табов
        //d($depth);

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

		$item = array('depth' => $depth, 'title' => $title, 'link' => false);
		$item['sid'] = static::$sid++;

        //step: проверям параметры
		if ($optsData) {
			static::_extractOpts($optsData, $item);
		}
        //d($item);

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


    private static $addr;
    private static $prev_depth;
    static function reset_depth() {
        static::$addr = array(-1);
        static::$prev_depth = 0;
    }
    static function _handle_addr(&$item) {
        $prev_depth = static::$prev_depth;
        $addr = static::$addr;
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
        $item['-addr'] = $addr;

        static::$prev_depth = $item['depth'];
        static::$addr = $addr;
    }

    static function _handle_link(&$item) {
        $link = prop($item, 'link', false);
        $nolink = prop($item, 'no-link') || $link === null;

        if ($nolink) {
            $link = false;
        } else {
            //step: проверям доп. случаи
                //case base: когда link просто указан в параметрах  link=test-1
            if (!$link || $link === true) { //case: нет параметра link или link стоит без значения
                $link = prop($item, 'name');
            }
            if (!$link) {
				$link = static::title2link($item['title']);
			}
        }

        $item['link'] = $link;
    }

    static function _handle_name(&$item) {
        $name = prop($item, 'name', false);
        $noname = prop($item, 'no-name') || $name === null;

        if ($noname) {
            $name = false;
        } else if (!$name || $name === true) { //case: нет параметра name или name стоит без значения
			$name = static::link2name($item['link']);
        }

        $item['name'] = $name;
    }

    static function title2link($title){
        $link = transliterate($title);
        $link = strtolower($link);
        $link = str_replace(' ', '-', $link);
        $link = "/$link";
        return $link;
    }

	static function link2name($link){
		return str_replace('/', '-', trim($link, '/'));
	}

}