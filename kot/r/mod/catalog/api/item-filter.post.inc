<?
_needphp('fq/str/str2val');
_needphp('json');
$Self = _kmod::self();

$Catalog = _site::name('catalog');


$_ctx = $Self::tempCtx(array(
	'section' => 'tombs',
	'name' => '',
	'value' => '',
	'id' => '',
));

$section = $_ctx['section'];
$id = $_ctx['id'];
$filterName = $_ctx['name'];
$filterValue = str2val($_ctx['value']);

$dataDir = $Catalog::path("data/filter/$section");
$fileName = $filterName.'.json';


$filePath = "$dataDir/$fileName";
$jsonData = array(
	'list' => array()
);
if (is_file($filePath)) {
	$jsonData = jsonFile_get_data($filePath);
}

if ($filterValue) {
	array_push($jsonData['list'], $id);
	$jsonData['list'] = array_unique($jsonData['list']);
} else {
	// Найти ключ элемента в массиве
	$key = array_search($id, $jsonData['list']);
	// Если элемент найден, удалить его
	if ($key !== false) {
		unset($jsonData['list'][$key]);
	}
	// Переиндексация массива после удаления элемента
	$jsonData['list'] = array_values($jsonData['list']);
}


$state = jsonFile_put_data($filePath, $jsonData, true);


return kmod_api::response(array(
	'state' => $state,
	'status' => $state,
	'res-list' => $jsonData,
));