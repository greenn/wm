<?#0.2.1
$pid; // объект адресса страницы

$contentTpl = _page($pid, 'content');
//dx($handlerTpl, site_tpl_($handlerTpl));
/*if (!$handlerTpl) {
	$handlerTpl = array('uc', 'content');
}*/

//pm-ko
//  нуу как-то не знаю, что за $pid, которого нету)

print site_tpl('page', 'html', array(
	'body' => site_tpl_($contentTpl)
));