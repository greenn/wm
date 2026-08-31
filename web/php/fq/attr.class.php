<?#1.3.20
_needphp('isAssoc');

/*
    im
	сделать как бы ещё
		чтобы примерно также как класс
		но по атрибутам
*/
class attr {

	//экранирование только двойных кавычек
	static function value($value, $mode = ENT_COMPAT){
		/*
		    https://stackoverflow.com/questions/20622676/escape-double-quotes-with-variable-inside-html-echo
		*/
		return htmlspecialchars($value, $mode, 'UTF-8'/*[q], false*/);
	}

	//public static function __callStatic($name, $arguments) {} #PHP>=5.3

	//преобразует аургменты в aa-массив значений атрибут-class
	static function _klass(/*args of {s,a} class-names*/){
		$list = array();
		foreach (func_get_args() as $data) {
			$value = null;
			if (is_stringable($data)) {
				$data = explode(' ', $data);
			}
			if (is_array($data)) {
				if (isOrdinal($data)) {
					foreach ($data as $class) {
						$list[$class] = true;
					}
				} else {
					$list = array_replace($list, $data);
				}
			}
		}
		return $list;
	}

	//преобразует аургменты в значение строки-атрибут class
	static function klass(/*args of {s,a} class-names*/){
		$attr = array(); //|attr_value|attr|
		//ak spaced-attrs
		$list = call_user_func_array('attr::_klass', func_get_args());

		foreach ($list as $value => $is_on) {
			if (!$value) continue;
			if ($is_on) $attr []= $value;
		}
		return join(' ', $attr);

	}

	//преобразует аургменты в строку-атрибут class
	static function klass_(/*args of {s,a} class-names*/){ //a_class
		$value = call_user_func_array('attr::klass', func_get_args());
		return $value ? "class=\"$value\"" : '';
	}


	static function css($data, $autoUnit = 'px'){
		if ($autoUnit === true) $autoUnit = 'px';
		$res = array();

		if (is_string($data)) {
			$res = array($data);
		} else if (isOrdinal($data)) {
			$res = $data;
		} else if (isAssoc($data)) {
			foreach ($data as $prop => $value) {
				if (!$value && !is_numeric($value)) continue;
				if (isOrdinal($value)) {
					$value = join(', ', $value);
				} else if (isAssoc($value)) {
					dx('attr need handle css assoc value', $prop, $value, $data);
				}
				if ($autoUnit) {
					if (is_numeric($value)) {
						$value .= $autoUnit; //px, %
					}
				}
				$res []= "$prop: $value";
			}
		}

		return join('; ', $res);
	}


	//out|buildAttributeString
	static function out($name, $value = false, $cfg = array()){
		static $defCfg = array();
		if (is_array($name)) $name = join('-', $name);
		if (is_array($value)) {
			$value = static::vals($value);
		}
		$setValue = (string) $value;
		$res = (string) $name;
		$isTrue = $value === true;
		$isFalse = $value === false;
		$isNull = $value === null;
		if ($isNull) { //ничего не выводом ¦ ''
			$res = '';
		} else if ($isFalse) { //выводом атрибут без значения, логика value = false ¦ attr
			$setValue = false;
		} else if ($isTrue) { //выводом пустой значение ¦ attr=""
			$setValue = '';
		}

		if ($res) {
			if (is_string($setValue) || $setValue) {
				$res .= '=';
				$res .= '"'.$setValue.'"';
			}
		}

		return $res;
	}

	//вывод значений в строку (ак из разных наборов) через пробел
	static function vals($args/*{s|ao|aa}*/, $opts = array()/*01*/) {
		$vals = array();
		if ($args) {
			$args = (array)$args;
			foreach ($args as $data) {
				if ($data) {
					$val = false;
					if (is_string($data)) {
						$val = $data;
					} else if (isOrdinal($data)) {
						$val = static::vals($data, $opts);
					} else if (isAssoc($data)) {
						//case: ak  vue class values, если true то выводом
						foreach ($data as $value => $cond) {
							if ($cond) {
								$val = $value;
							}
						}
					}
					if ($val) {
						$vals []= $val;
					}
				}
			}
		}
		return join(' ', $vals);
	}
	static function vals_(/*{s,a}*/) {
		return static::vals(func_get_args());
	}


	//вывод данные атрибутов в строку
	static function as($data/*{s,a}*/) {
		$stack = array();

		$isAssoc = isAssoc($data);
		foreach ((array)$data as $key => $value) {
			if ($isAssoc) {
				$res = static::out($key, $value);
			} else {
				$res = static::out($value);
			}
			if ($res) {
				$stack []= $res;
			}
		}

		return join(' ', $stack);
	}


	//выводим строку, если толькое сть значение
	static function out_val($name, $value){
		$res = '';
		if ($value) {
			$res = static::out($name, $value);
		}
		return $res;
	}
	static function out_vals($data){
		$stack = array();
		foreach ($data as $key => $value) {
			$res = static::out_val($key, $value);
			if ($res) {
				$stack []= $res;
			}
		}
		return join(' ', $stack);
	}

	//выводим атрибуты из данных в строку
	/* eg
	 	 $as = attr::asd(array('pt50', 'pb30'), $_ctx['as'], array('pb30' => null)); //pt50
	*/
	static function asd(/*s,aa,ao*/){ //asData
		$args = func_get_args();
		$attrs = static::parse($args);
		//if (_x('dbg1')) dx($attrs, $args);
		return static::as($attrs);
	}

	static function parse($data){
		$res = array();
		if ($data === '') {}
		else if ($data === null) $res['null'] = null;
		else if ($data === false) $res['false'] = null;
		else if ($data === true) $res['true'] = null;
		else if (is_array($data) && $data) {
			if (isAssoc($data)) {
				$res = array_replace($res, $data);
			} else {
				foreach ($data as $item) {
					$res = array_replace($res, static::parse($item));
				}
			}
		} else if (is_string($data) && $data) {
			$res = static::parse_string($data);
		} else if (!$data) {
			//case eg: $data = array();
		} else {
			d(1);
			dx('unknown attribute data for parsing', $data);
		}
		//if ($data) d('attr::parse', $data, $res);
		return $res;
	}

	static function parse_string($string) {
		preg_match_all('/([\w\-_]+)(="([^"]*)")?/', $string, $matches, PREG_SET_ORDER);

		$attributes = [];
		foreach ($matches as $match) {
			$attrName = $match[1]; // Имя атрибута
			$attrValue = $match[3] ?? false; // Значение атрибута, если оно есть
			$attributes[$attrName] = $attrValue;
		}
		//d('attr::parse_string', $string, $attributes);
		return $attributes;
	}


}

if (false) {
	_i::img('', 'avh');
}