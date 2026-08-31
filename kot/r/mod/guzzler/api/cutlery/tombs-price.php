<?
_needphp('isAssoc');

$opt;
$jsonData; // пришедшие json-данные

$status['приступаем к еде'] = 'ням-ням';



$edibleData = array();

if (isAssoc($jsonData)) {
	$jsonData = array($jsonData);
}

$prevKey = null;
foreach ($jsonData as $item) {
	$key = _prop($item, 'model_number');
	$value = _prop($item, 'dimensions');
	$isComplex = _prop::has($item, 'complex');
	if (!$value) {
		$value = $prevKey;
	}

	if (isAssoc($value)) {
		$valueData = array();
		foreach ($value as $size => $prices) {
			$priceData = array(
				'size' => $size,
				'prices' => $prices,
			);
			if ($isComplex) {
				$priceData['complex'] = $item['complex'];
			}
			$valueData []= $priceData;
		}
		$value = $valueData;
	}

	$edibleData[$key] = $value;
	$prevKey = $key;
	//d($key);
}

//dx('едим-цены', $jsonData, $edibleData, _prop($opt, 'json-merge-data'));


$status['остатки'] = strlen(json_encode($jsonData)) - strlen(json_encode($edibleData));
$jsonData = $edibleData;

//dx($jsonData);

$_mergeDeep = false;

