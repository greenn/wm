<?
_needphp('isAssoc');

$opt;
$jsonData; // пришедшие json-данные

$status['приступаем к еде'] = 'ням-ням';



$edibleData = array();

if (isAssoc($jsonData)) {
	$jsonData = array($jsonData);
}

$prevValue = null;
foreach ($jsonData as $item) {
	$key = _prop($item, 'model_number');
	$value = _prop($item, 'dimensions');
	if (!$value) {
		$value = $prevValue;
	}

	if (is_numeric($value)) {
		$fndKey = $value;
		//d('look for', $key, $fndKey, $edibleData);
		foreach ($edibleData as $index => $_item) {
			if (isset($edibleData[$fndKey])) {
				$value = $edibleData[$fndKey];
				//d('fnd for', $key, $value);
				break;
			}
		}
	}


	$edibleData[$key] = $value;
	$prevValue = $value;
	//d($key);
}

//dx('едим-цены', $jsonData, $edibleData, _prop($opt, 'json-merge-data'));


$status['остатки'] = strlen(json_encode($jsonData)) - strlen(json_encode($edibleData));
$jsonData = $edibleData;

//dx($jsonData);

$_mergeDeep = false;

