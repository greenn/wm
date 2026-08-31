<?

$Self = _kmod::self();

$_ctx = $Self::tempCtx(array(
	'name' => '', //plate / target
	'stomach' => '',
	'id' => '',
));

$itemId = $_ctx['id'];

$name = $_ctx['name'];
$stomach = $_ctx['stomach'];
if ($stomach) {
	$name = $stomach;
}

$jsonPath = $Self::path("stomach/json/$name.json");
$jsonData = jsonFile_get_data($jsonPath);
d($name, count($jsonData), $jsonData);
if ($itemId) {
	d($itemId, _prop($jsonData, $itemId));
}




if ($stomach === 'morgue-list') {
	$total = array();
	foreach ($jsonData as $name => $list) {
		$total = array_merge($total, $list);
	}

	dx($total, $jsonData);
}

