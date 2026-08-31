<?#0.9.0 - lang functionality

_needphp('dataPath.class');

//manager текущего языка (получить/поставить)
function cur_lang(){
	static $lang = 'ru';
	if (func_num_args() === 1) {
		prev_lang($lang);
		$lang = func_get_arg(0);
	}
	return $lang;
}

//05 получить/поставить предыдущий язык (если он менялся в текущем запросе)
function prev_lang(){
	static $lang = 'ru';
	if (func_num_args() === 1) {
		$lang = func_get_arg(0);
	}
	return $lang;
}

//получить перевод текста из site-ресурса
function site_lang($rName, $text, $lang = true){
	return site($rName, 'lang', $text, $lang);
}

//получить перевод текста из page-ресурса
function page_lang($pid, $text, $lang = true){
	return page($pid, 'lang', $text, $lang);
}

//для определения языков в Ordinal массиве
function lang_array($data){
	static $order = array();
	if (!$order) $order = _lang::$list;;
	if (isOrdinal($data)) {
		$res = array();
		foreach ($data as $index => $tx) {
			if (isset($order[$index])) {
				$index = $order[$index];
			}
			$res[$index] = $tx;
		}
		$data = $res;
	}
	return $data;
}
//для определения языков в массиве аргументов
function lang_(/*$tx1, $txN*/){
	return lang_array(func_get_args());
}

//предворяет url, lang-префиксом
function lang_url($url, $lang = true) {
	if ($lang === true) $lang = cur_lang();
	return "/$lang/".ltrim($url, '/');
}

//берёт из данных нужный язык
function _lang($data, $lang = true){
	$res = false;
	if ($lang === true) $lang = cur_lang();
	if (is_array($data)) {
		$res = prop($data, $lang); //берём перевод из массива
		if (!$res && !is_string($res)) {
			if ($res = _lang::find_base_value($data)) {
				$res = _lang::otherwise_val($res, $lang);
			}
		}
	} else if (!$res) {
		$res = _lang::otherwise_val($data, $lang);
	}
	return $res;
}

function _lang_($data, $lang = true){
	$data = call_user_func_array('lang_', $data);
	return _lang($data, $lang);
}

function _lang_v1($data, $lang = true, $usePrefix = true){
	//get_translate($db, $code, $lang)
	if ($lang === true) $lang = cur_lang();
	$error_prefix = $usePrefix ? "[$lang] -" : '';
	if (is_array($data)) {
		$res = prop($data, $lang);
		if (!$res && !is_string($res)) { //case: в данных нет нужного языка
			$res = $error_prefix.reset($data);
		}
	} else {
		//case: в данных не было выбора языка
		$res = $error_prefix.(string)$data;
	}
	return $res;
}



/*
	plan
		здесь будет подгрузка данных из модулей с переводами
*/
class _lang {
	static $dbg; //запись для идентификации вызовы
	static function dbg($sid = true){
		if ($sid === true) $sid = 'lang-menu'; //ручная установка
		return static::$dbg === $sid;
	}

	static $db = array();
	static $list = array('ru', 'en'); //pro('lang', 'list');
	static $base = 'ru'; //pro('lang', 'base');
	static $otherwiseUsePrefix = true;

	//получить значение, при отсутсвтии перевода
	//значение, если нету перевода
	static function otherwise_val($code, $lang){
		if (is_array($code)) $code = join('/', $code);
		if (!static::$otherwiseUsePrefix) return $code;
		//return "_{$lang} $code";
		return "〈{$lang}〉 $code";
		return "[$lang] $code";
		return rand_val(array(
			"〈{$lang}〉 $code",
			"$lang| $code",
			"/$lang/ $code",
			"|$lang| $code",
			"\\$lang/ $code",
			"$lang: $code",
			"[$lang] $code",
			"[$lang: $code]",
			"$lang:$code", //'
			"{$lang}_$code",
			"{$lang}_ $code",
			"_{$lang}_ $code",
			"_{$lang} $code",
			"{$lang} $code",
		));
	}


	//проверяем являются ли данные массивом переводов
	static function is_lang_array($data){
		//return array_key_exists(static::$base, $data);
		if (is_array($data)) {
			foreach (static::$list as $lang) {
				if (array_key_exists($lang, $data)) return true;
			}
			return static::is_ordinal_lang_array($data);
		}
		return false;
	}

	//u-case: проверяс ordinal массив, если там не массивы внутри - array(lang1, lang2)
	static function is_ordinal_lang_array($data){
		if (isOrdinal($data)) {
			$isOrdinalLang = true;
			foreach ($data as $key => $value) {
				$isOrdinalLang *= !is_array($value);
			}
			return $isOrdinalLang;
		}
		return false;
	}

	//static function build_lang_item($data, $code, $lang){}
	//найти значение в lang-данных (def > base > any)
	static function find_base_value($data){
		$res = prop($data, 'def');
		if (!$res) $res = prop($data, static::$base);
		if (!$res) foreach ($data as $lang => $value) {
			if ($value) {
				$res = $value;
				break;
			}
		}
		return $res;
	}

	//создаём альтернативное значение для перевода
	static function create_lang_value($code, $lang, $data){
		$value = static::find_base_value($data);
		//dx('create_lang_value', $code, $lang, $data, '=find=', $value);
		if ($value) {
			$value = static::otherwise_val($value, $lang);
		} else {
			$value = static::otherwise_val($code, $lang);
		}
		return $value;
	}


	//приображение Конфига Переводов в нормальный вид ('lang1' => 'перевод1', 'lang2' => 'перевод2')
	static function build_lang_cfg($data){
		$res = array();
		//dx($data);
		foreach ($data as $key => $value) {
			//d($data, $key, $value);
			//d($value, static::is_lang_array($value), static::dbg(), static::$dbg);
			//if (is_array($value) && !static::is_lang_array($value)) {
			if (is_array($value) && !static::is_lang_array($value)) {
				//case: многоуровненый массив данных перевода (prop > sub > lang)
				//if (static::dbg()) d('case-1');
				//d('case-1a', $key, $value, $data);
				$res[$key] = static::build_lang_cfg($value);
				//d('case-1b', $key, $value, $res[$key]);

			} else {
				//if (static::dbg()) d('case-2');
				//d('case-2a', $key, $value, $data);
				$res[$key] = static::build_lang_data($value, $key);
				//dx('case-2b', $key, $value, $res[$key]);
			}
		}
		return $res;
	}

	//приображение Данных Переводов в нормальный вид ('lang1' => 'перевод1', 'lang2' => 'перевод2')
	static function build_lang_data($data, $code){
		//dx($data, $code);
		$res = $data;

		if (is_string($data)) {
			//case: припудренный case для ручного указания ['Текст' => 'Перевод-на-другой-язык']
			$trans1 = $code;
			$trans2 = $data;
			$res = array($trans1, $trans2);
		}

		if (isOrdinal($res)) {
			//$dic = merge_keys_values($order, $dic, true, '-');
			$_data = $res;
			$res = array();
			foreach (static::$list as $index => $lang) {
				//$res[$lang] = static::build_lang_item($data, $code, $lang);
				//$otherwise = static::otherwise_val($code, $lang, $res);
				$otherwise = static::otherwise_val($code, $lang);
				//d($res, $index, prop($_data, $index));
				$res[$lang] = prop($_data, $index, $otherwise);
			}
			//dx($res);
		}

		///if (isAssoc($res)) {
		//step: проверяем наличие всех языков
		foreach (static::$list as $index => $lang) {
			if (!prop($res, $lang)) { //{f,u,s0}
				$res[$lang] = static::create_lang_value($code, $lang, $res);
			}
		}

		return $res;
	}

	//получить словарь, для указанного языка
	static function get_dic($db, $lang){
		$dic = array();
		foreach ($db as $code => $data) {
			if (!static::is_lang_array($data)) {
				$dic[$code] = static::get_dic($data, $lang);
			} else {
				$dic[$code] = $data[$lang];
			}
		}
		return $dic;
	}

	// Получить результат перевода из данных ($db) по термину($code) и языку($lang)
	static function get_translate($db, $code, $lang){
		//d($db, $code, $lang);
		$path = (array)$code;

		$res = dataPath::get($db, $path);
		//here: результат может быть срезом, и не быть сразу lang_array
		//d($db, $res);

		$res = static::_translateData($res, $lang);
		//d($res);
		if (!$res) {
			//case: нету данных для перевода (нет db, или нет данного ключа)
			$res = static::otherwise_val($code, $lang);
			//dx($res);
		}
		return $res;
	}


	//проивести перевод подготовленных данных {a,aL}
	static function _translateData($data, $lang){
		//d(static::dbg(), static::$dbg);
		//dx('_translateData', $data, $lang);
		if (is_array($data)) {
			if (static::is_lang_array($data)) {
				//if (!isset($data[$lang]))
				//if (!prop($data, $lang)
				//[pw] по идеи, здесь должны быть подготовленные, но если что упадёт, надо будет разрулить
				return $data[$lang];
			} else {
				//case: срез массив (lang-данные где-то внутри)
				foreach ($data as $key => $value) {
					$data[$key] = static::_translateData($value, $lang);
				}
			}
		}
		return $data;
	}

}