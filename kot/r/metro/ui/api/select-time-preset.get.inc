<?

$list = array();
$list []= array('value' => '', 'text' => '- укажите период-');

$preset = include 'data/time-preset.data.inc';
//dx($preset);
foreach ($preset['data'] as $data) {
	if (prop($data, 'skip')) continue;
	$item = array(
		'value' => $data['opts']['name'],
		'text' => $data['line-res'],
		//'weight' => $data['opts']['weight'],
	);

	$list []= $item;
}

return kot_api::response(array(
	'options' => $list,
	'info' => $preset['info'],
));