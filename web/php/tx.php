<? #2.22
// про переводы текстовых надписей


define('TX_PATH_PATTERN', PHP.'/tx/%s.dic.php');
function tx($txt, $lang = true){
	if ($lang === true) $lang = SYS_LANG; //'ru'
	$dicName = 'common'; //all|each
	if (is_array($txt) && count($txt) === 2) { //array('common', $textString)
		$dicName = $txt[0];
		$txt = $txt[1];
	}

	$dicPath = sprintf(TX_PATH_PATTERN, $dicName);
	$dictionary = inc($dicPath, INC_RES_AS_DATA);

	$word = prop($dictionary, $txt, null); //данные о ключе
	$translate = prop($word, $lang, $txt); //данные перевода

	return $translate;
}


function tx_ucfirst($txt, $lang = true){
	$tx = tx($txt, $lang);
	if (!is_string($tx)) return $tx;

	$encoding = SYS_ENCODING; //mb_detect_encoding($txt)

	//https://stackoverflow.com/questions/2517947/ucfirst-function-for-multibyte-character-encodings
	$strlen = mb_strlen($tx, $encoding);
	$firstChar = mb_substr($tx, 0, 1, $encoding);
	$then = mb_substr($tx, 1, $strlen - 1, $encoding);
	return mb_strtoupper($firstChar, $encoding) . $then;
}


/*
	Если нету, то заноситься в список требуемых переводов
	с указанием файла откуды был запрос
*/

#0.3.0 Переименовывает Английские названия месяцев в Русские
//ru_month(date("j F Y", $item['date_tmp'])
//oo web/php/w/bb/rudic/str.php
function ru_month($str, $transform = false) {
	$str = str_replace(
		array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
		array('Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'),
		$str
	);
	if ($transform === 'uppercase') $str = mb_strtoupper($str);
	if ($transform === 'lowercase') $str = mb_strtolower($str);
	return $str;
}

#0.3.1 Переименовывает Английские названия дней в Русские
function ru_day($str, $transform = false) {
	static $data = array('Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресение');
	if ($transform) foreach ($data as &$item) {
		if ($transform === 'uppercase') $item = mb_strtoupper($item);
		if ($transform === 'lowercase') $item = mb_strtolower($item);
	}

	$str = str_replace(
		array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
		$data,
		$str
	);
	
	return $str;
}

/*

monthNames: [ "Январь","Февраль","Март","Апрель","Май","Июнь",
"Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь" ],
monthNamesShort: [ "Янв","Фев","Мар","Апр","Май","Июн",
"Июл","Авг","Сен","Окт","Ноя","Дек" ],
dayNames: [ "воскресенье","понедельник","вторник","среда","четверг","пятница","суббота" ],
dayNamesShort: [ "вск","пнд","втр","срд","чтв","птн","сбт" ],
dayNamesMin: [ "Вс","Пн","Вт","Ср","Чт","Пт","Сб" ],
weekHeader: "Нед",

*/