<?
_needphp('json');
$Self = _kot::self();

//$json = $Self::path($Self::relDir('data/stations.json'));
$json = $Self::path('api/data/mock/stations.json');
$jsonData = jsonFile_get_data($json);

$list = array();
$inf = array();

$lim = 500;
$excludeIdList = array(737, 513, 514, 738, 739);
foreach ($jsonData['result'] as $data) {
	if (in_array($data['id'], $excludeIdList)) continue;
	if ($lim-- < 0) continue;
	$cat = prop($data, 'adminRegionName', '-');
	if (!isset($inf[$cat])) $inf[$cat] = 0;
	$inf[$cat]++;

	$item = array(
		'value' => (string)$data['id'],
		'text' => $data['shortName'],
	);
	$list []= $item;
}
/*
function customCompare($a, $b) {
	if ($a[1] == $b[1]) {
		return 0;
	}
	return ($a[1] < $b[1]) ? -1 : 1;
}

$ar = [['a', 12], ['b', 11]];

usort($ar, 'customCompare');
*/

usort($list, function($a, $b) {
	return $a['text'] > $b['text'];
	//$result = strcmp("apple", "banana"); // Вернет отрицательное число, так как "apple" < "banana"
	//return strcmp($a['text'], $b['text']);
});

array_unshift($list, array('value' => '', 'text' => '- название станции -'));

return kot_api::response(array(
	'options' => $list,
	//'info' => $preset['info'],
));