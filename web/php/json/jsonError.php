<?#1.1.0

function jsonLastErrorMsg(){
	if (!is_callable('json_last_error')) {
		return 'Даже json_last_error отсутвует';
	} else {
		return jsonErrorMsg(json_last_error());
	}
}

function jsonErrorMsg($errorId){
	switch ($errorId) {
		case JSON_ERROR_NONE:
			return 'Ошибок нет';

		case JSON_ERROR_DEPTH:
			return 'Достигнута максимальная глубина стека';

		case JSON_ERROR_STATE_MISMATCH:
			return 'Некорректные разряды или не совпадение режимов';

		case JSON_ERROR_CTRL_CHAR:
			return 'Некорректный управляющий символ';

		case JSON_ERROR_SYNTAX:
			return 'Синтаксическая ошибка, не корректный JSON';

		case JSON_ERROR_UTF8:
			return 'Некорректные символы UTF-8, возможно неверная кодировка';

		default:
			return 'Неизвестная ошибка';
	}
}