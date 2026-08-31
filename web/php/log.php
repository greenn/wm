<?#1.1.1019

_needphp('_s/init');
_needphp('log/log.class');

function slog($id, $msg){
	$args = array_slice(func_get_args(), 2);
	$text = "[$id] $msg";
	log::rec($text, $args);
	//return log::slogToHtml_(func_get_args());
}

//логирование данных для разработки
function _log($text/*, $ctxItem1, $ctxItemN*/){
	$args = array_slice(func_get_args(), 1);
	log::rec($text, $args);
}
//отключение вызова, путём добавления спереди _
function __log(){}

//системные сообщения (aka warn), которые можно выкидывать на страницу для информирования
function _msg($text/*, $ctxItem1, $ctxItemN*/){
	$args = array_slice(func_get_args(), 1);
	log::rec($text, $args, 'msg');
}

//системные ошибки, которые можно выкидывать на страницу для информирования
function _error($text/*, $ctxItem1, $ctxItemN*/){
	$args = array_slice(func_get_args(), 1);
	log::rec($text, $args, 'error');
}

//system debug Data
function _dd(){
	return log::$list;
}