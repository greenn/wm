<?
_needphp('json');
$Self = _kot::self();


$data = array(
	'выбрать',
	'Автобус',
	'Троллейбус',
	'Трамвай',
);

$options = array();
foreach ($data as $index => $title) {
	$options []= array(
		'value' => $index === 0? '' : $index,
		'text' => $title
	);
}

foreach ($options as &$data) $data['value'] = (string) $data['value'];

return kot_api::response(array(
	'options' => $options,
	//'info' => $preset['info'],
));