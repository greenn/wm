<?
$_ctx; $Self;


$dataName = _prop($_ctx, 'data', 1);
//dx($dataName);
$data = file_get_contents($Self::path("mock/1/$dataName.mock"));


$_ctx = array_replace($_ctx, array(
	'food' => $data,
	'ingredients' => array(
		'dish' => 'json',
		'cutlery' => 'tombs-price',
        'plate' => 'tombs-price3',
	),
	'seasoning' => array(
		'json-save' => true,
		'json-filter-comment' => true,
		'json-merge-data' => true,
		'json-backup-data' => true,
		'json-try-fix' => true
	)
));