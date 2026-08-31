<?
$_ctx; $Self;


$dataName = _prop($_ctx, 'data', 1);
//dx($dataName);
$selfName = basename(__FILE__, '.php');
$data = file_get_contents($Self::path("mock/$selfName/$dataName.mock"));


$_ctx = array_replace($_ctx, array(
	'food' => $data,
	'ingredients' => array(
		'salt' => 'product_name',
		'dish' => 'json',
		'cutlery' => 'catalog-items',
        'plate' => 'catalog-odezhda',
	),
	'seasoning' => array(
		'json-save' => true,
		'json-filter-comment' => true,
		'json-merge-data' => true,
		'json-backup-data' => true,
		'json-try-fix' => true
	)
));