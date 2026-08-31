<?

$list = array();
$list []= array('value' => '', 'text' => '- укажите период-');

$preset = include 'data/time-preset.data.inc';
//dx($preset);
foreach ($preset['data'] as $data) {
	//d($data);
	if (prop($data, 'skip')) continue;
	if (propChain($data, array('opts', 'time'))) continue;
	$item = array(
		'value' => (string) $data['opts']['name'],
		'text' => $data['line-res'],
		//'weight' => $data['opts']['weight'],
	);

	$list []= $item;
}


return kot_api::response(array(
	'options' => $list,
	'info' => $preset['info'],
));