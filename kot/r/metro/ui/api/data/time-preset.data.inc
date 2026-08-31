<?
_needphp('parser/strDataParser.class');

$strData = <<<text
Последний час       \ name=last-hour time=true
Последние 24 часа   \ name=last-24h time=true
Сегодня             \ name=today rule=now
Вчера               \ name=yesterday
Эта неделя          \ name=this-week
Последние 7 дней    \ name=last-7d
Последние 30 дней   \ name=last-30d
Последние 90 дней   \ name=last-90d
Последний год       \ name=last-year
text;

$ruleMap = array(
	'last-hour' => array('hour' => -1),
	'last-24h' => array('hour' => -24),
	'today' => array(),
	'yesterday' => array('day' => -1),
	'this-week' => array('day' => -date('N')),
	'last-7d' => array('day' => -7),
	'last-30d' => array('day' => -30),
	'last-90d' => array('day' => -90),
	'last-year' => array('year' => -1),
);

$list = array();
$list []= array('value' => '', 'text' => '- укажите период-');

$listData = strDataParser::parse($strData);
//dx($listData);
//dx(prop(reset($listData), 'opts'));
foreach ($ruleMap as $name => &$ctx) {
	foreach ($listData as $data) {
		if ($data['opts']['name'] ===  $name) {
			$ctx['title'] = $data['line-res'];
		}
	}
}

return array(
	'data' => $listData,
	'info' => $ruleMap,
);