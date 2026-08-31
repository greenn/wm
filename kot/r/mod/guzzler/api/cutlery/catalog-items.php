<?
_needphp('isAssoc');

$set;
$opt;
$jsonData; // пришедшие json-данные

$status['приступаем к еде'] = 'ням-ням';


$keyName = _prop($set, 'salt');


$edibleData = array();

if (isAssoc($jsonData)) {
	$jsonData = array($jsonData);
}
//dx($jsonData, $keyName);
foreach ($jsonData as $item) {
	$key = _prop($item, $keyName);
	$hasKeyData = _prop::has($item, $keyName);
	if (!$key) $key = serialize($item);
	if (!is_numeric($key)) $key = ($hasKeyData ? 'a': 's').hash('adler32', $key);

	$edibleData[$key] = $item;
}

//dx('едим-цены', $jsonData, $edibleData, _prop($opt, 'json-merge-data'));

$status['остатки'] = strlen(json_encode($jsonData)) - strlen(json_encode($edibleData));
$jsonData = $edibleData;

//dx($jsonData);

$_mergeDeep = true;
$_kSort = false;

