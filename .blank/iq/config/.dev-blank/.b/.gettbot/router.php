<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

//dx(pro::$cfg, $_REQUEST, get_web_constants(), get_defined_vars());

//if (gt_has('en')) cur_lang('en');

$pid = pageUri; //ak $pageName
//step: опредеяем язык страницы и её имени
if (in_array(page1, _lang::$list)) {
	cur_lang(page1);
	unset($pageParts[0]);
	$pid = join('/', $pageParts);
}
if (!$pid) $pid = 'index';

_page::$cur_pid = $pid; //запоминаем имя текущей страницы


//step: определяем handler
//dx(_page($pid));
if (_page($pid)) {//case: если есть данные у страницы
	//$handlerName = page($pid, 'prop', 'handler');
	$handlerName = _page($pid, 'handler');
	if (!$handlerName) {//case: handler явно не ууказан в кониге
		$handlerName = $pid;
		$handler = pro('configDir')."/router/$handlerName.php";
		if (!is_file($handler)) { //case: нету handler-файла по имени страницы
			//step: указываем хендлер по умолчанию
			$handlerName = 'page'; //case: default handlerName
		}
	}
} else {
	//print site('page', 'pid', '404'); exit;
	$handlerName = '404';
}

//step: запускаем handler
//dx($handlerName);
$handler = pro('configDir')."/router/$handlerName.php";
include $handler;