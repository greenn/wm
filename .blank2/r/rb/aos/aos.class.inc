<?#0.2.3
/*
	auto-otder
			str: name / easing  \oo $strPropsOrder
			num: duration / delay \oo $digitPropsOrder
	eg:
		name duration easing delay
		duration name easing delay
*/
_needphp(
	'isAssoc',
	'json',
	'fq/_is'
);

_rb::reg('aos', array(
	'nc' => array(
		'base' => 'aos'
	),
	'val' => array(
		'init' => array(
			'easing' => 'ease-out-back',
			'duration' => 1000, //css('aos_tm'),
			'offset' => 0,
			'mirror' => false,
			'once' => true,
		)
	)
));

//name, duration, easing, delay

class rb_aos extends rb {

	static $OFF = false; //возможность быстрого отключения
	//static $v = '2.3.4';
	static $v = '3.0.0b6';


	static function req($init = true){
		if (static::$OFF) return;
		$v = static::$v;
		css::req(-2, false, "/js/aos/$v/aos.css");
		js::req(-2, false, "/js/aos/$v/aos.js");
		if ($init) {
			js::req(-2, false, array('rb', 'aos', 'init_js', true, false));
		}
	}

	static function req_waypoints(){
		js::req(-1, false, '/js/waypoints/4.0.1c/jquery.waypoints.js');
		js::req(-1, false, '/js/waypoints/4.0.1c/inview.min.js');


		//js::req(-1, false, '/js/waypoints/4.0.1/waypoint.js');
		//js::req(-1, false, '/js/waypoints/4.0.1/shortcuts/inview.js');


		//js::req(-1, false, '/js/waypoints/4.0.1/shortcuts/inview.min.js');

		//js::req(-1, false, '/js/waypoints/4.0.1/jquery.waypoints.min.js');
		//js::req(-1, false, '/js/waypoints/4.0.1/noframework.waypoints.js');
	}

	static function parse_string($str_cmd){
		static $propNames = array(
			'n' => 'name',
			't' => 'duration', 'dur' => 'duration',
			'd' => 'delay', 'dly' => 'delay',
			'e' => 'easing',
			'a' => 'anchor',
			'apos' => 'anchor-placement',
			'pos' => 'offset'
			//mirror
			//once
		);
		$strPropsOrder = array('name' => '', 'easing' => '');
		$digitPropsOrder = array('duration' => '', 'delay' => '');
		$valueAsProp = array('once', 'mirror');

		$attrs = array();
		$regex = '~'.join('', array( // https://regex101.com/r/qaQmOa/3
				'(?:',
				'([_a-z-]+)', //propName
				'\:',
				')?',
				'(?:',
				'([#a-z-]+[a-z0-9-]*)', //stringProp
				//возможно id - не начинающиеся с цифры
				//Иначе есть перекрывание digitProp
				'|', //or
				'(', //digitProp
				'([-\d]+)',
				'(s|ms)?',
				')',
				')',
			)).'~m'; //https://regex101.com/r/qaQmOa/2
		//для более чоткого разобра, сначала можно бить строку по пробелам на составные часть и разбирать уже их

		preg_match_all($regex, $str_cmd, $matches, PREG_SET_ORDER);

		if ($matches) foreach ($matches as $match) {
			$prop = null;
			$value = null;
			switch (count($match)) {
				case 3: { //named?  stringProp
					$value = $match[2];
					if (in_array($value, $valueAsProp)) { //specific case
						$prop = $value;
						$value = 'true';
					} else { //normal case
						$prop = key($strPropsOrder); //имя ключа первого элемента
						if ($name = $match[1]) {
							$prop = prop($propNames, $name, $name);
						}
						unset($strPropsOrder[$prop]);
					}
				} break;
				case 5: case 6: { //named? digitProp + digitUnit?
				$value = (integer)$match[4];
				if (isset($match[5])) {
					if ($match[5] == 's') $value = $value * $match[5];
				}

				if ($name = $match[1]) {
					$prop = prop($propNames, $name, $name);
				} else {
					$prop = key($digitPropsOrder); //имя ключа первого элемента а в текущем стеке
				}
				unset($digitPropsOrder[$prop]);
			} break;
			}
			//d($prop, $value);
			if ($prop && is_stringed($value)) {
				$attrs[$prop] = $value;
			}
		}

		//d($str_cmd, $matches, $attrs);
		return $attrs;
	}

	//превращает attr-строку в соответсвющие данные

	static function attrData($attrString){
		static $attr_name = 'data-aos';
		static $attr_start = false;
		if (!$attr_start) $attr_start = "$attr_name-";
		static $attr_start_length = false;
		if (!$attr_start_length) $attr_start_length = strlen($attr_start);

		$resData = array();
		$regex = join('', array('~',
			'([^=]+)',
			'(:?',
			'=\"([^"]*)\"',
			')?',
			'[\s]*',
			'~m')); //https://regex101.com/r/RAtfkU/2

		preg_match_all($regex, $attrString, $matches, PREG_SET_ORDER);

		if ($matches) foreach ($matches as $match) {
			$attr_prop = $match[1];
			$attr_value = $match[3];

			if (strpos($attr_prop, $attr_start) === 0) {
				$attr_prop = substr($attr_prop, $attr_start_length);
			} elseif ($attr_prop === $attr_name) {
				$attr_prop = 'name';
			}
			$resData[$attr_prop] = $attr_value;
		}
		return $resData;
	}


	//превращает поступившие данные в assoc-массив опций
	//$extOptionsPriority - приоритет assoc-данных перед str-данными
	static $extOptionsPriority = false; //01
	static function optionsData($confData, $extOptionsPriority = null){ //|takeOptions|optionsData|
		$extOptions = array();
		if (isOrdinal($confData)) {
			$optionsStringData = array();
			foreach ($confData as $optionsData) if (is_valuable($optionsData, 0)) {
				if (is_array($optionsData)) {
					$extOptions = array_replace($extOptions, $optionsData);
				} else {
					$optionsStringData []= $optionsData;
				}
			}
			$optionsString = join(' ', $optionsStringData);
			$confData = $optionsString;
		}

		if (is_stringable($confData)) {
			$confData = $parserResult = static::parse_string($confData);
		}
		if ($extOptions) {
			if (is_null($extOptionsPriority)) $extOptionsPriority = static::$extOptionsPriority;
			$confData = $extOptionsPriority ? array_replace($confData, $extOptions) : array_replace($extOptions, $confData);
		}
		//d(func_get_arg(0), @$optionsStringData, $extOptions, @$parserResult);
		return $confData;
	}


	//превращает assoc-массив в строку html-атрибутов
	static function attrs($data){
		$attrs = array();
		foreach ($data as $prop => $value) {
			$suffix = ($prop == 'name') ? '' : "-$prop";
			$attrs []= "data-aos{$suffix}=\"$value\"";
		}
		return join(' ', $attrs);
	}

	//по заданным данным выдаёт строку html-атрибутов
	static function set_attr($optionsConfig) { //set|attrCode|attr_cmd|set_attr
		$optionsData = static::optionsData($optionsConfig);
		//d($optionsConfig, $optionsData);
		$attrs = static::attrs($optionsData);
		return $attrs;
	}


	static function init_js($conf = true, $tag_wrap = false){
		if (static::$OFF) return '';

		if ($conf === true) $conf = static::val('init');
		$optionsData = static::optionsData($conf);
		//dx($optionsData);
		$html = array(
			'$(function(){',
				'AOS.init(',
					jsonPrettyEncode($optionsData),
				');',
			'});',
		);
		if ($tag_wrap) {
			array_unshift($html, '<script type="text/javascript">');
			array_push($html, '</script>');
		}
		return join(newline, $html);
	}

}

function _aos($cmd1/*, $cmdN*/){
	$cmdArgs = func_get_args();
	return rb_aos::set_attr($cmdArgs);
}

function aos_set(/*$cmd1, $cmdN*/){
	static $options = array();
	if (func_num_args()) {
		$cmdArgs = func_get_args();
		$options = rb_aos::optionsData($cmdArgs);
	}
	return $options;
}

function aos_(/*$cmd1, $cmdN*/){
	$cmdArgs = func_get_args();
	array_unshift($cmdArgs, aos_set());
	//d($cmdArgs, func_get_args());
	return rb_aos::set_attr($cmdArgs);
}

function _aosData($attrString){
	return rb_aos::attrData($attrString);
}


/*
	dd
		aos::delay()

	dd  aos_set(null, $cmd1)
		https://www.php.net/manual/en/function.array-diff-assoc.php

*/