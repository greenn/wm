<?
_needphp('json');
$Self = _kot::self();


$ngpt = kot_api::get_data_prop('options', 'ui/select-ngpt');

//dx($ngpt);

$optionsData = array();

foreach ($ngpt as $id => $optionData) {
	$itemId = $optionData['value'];
	$itemTitle = $optionData['text'];

	if (!$itemId) continue;

	$data = array(
		'выбрать',
	);

	for ($i = count($data); $i <= 10; $i++) {
		$data []= "$itemTitle-{$i}";
	}

	$options = array();
	foreach ($data as $index => $title) {
		$options []= array(
			'value' => $index === 0? '' : $index,
			'text' => $title
		);
	}

	foreach ($options as &$option) $option['value'] = (string) $option['value'];

	$optionsData[$id] = $options;
}



return kot_api::response(array(
	'optionsData' => $optionsData,
	//'info' => $preset['info'],
));