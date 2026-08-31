<?
_needphp('dirToArray.class');

$Self = _kmod::self();
$staus = array();

$_ctx = $Self::tempCtx(array(
	'name' => '',
));
$name = $_ctx['name'];

$list = array();

$path = '';
$ext = '';
switch ($name) {
	case 'cutlery': case 'dish': {
		$ext = '.php';
		$path = $Self::relDir($name);
	} break;

	case 'plate': { //target
		$ext = '.json';
		$path = 'stomach/json';
	} break;
}

if ($path) {
	$fileList = dirToArray::apply(array(
		'path' => $Self::path($path),
		'keepDots' => false,
		'depth' => 0,
	));
	if ($ext) {
		$filteredList = dirToArray::filterByExt($fileList, $ext);
		foreach ($filteredList as $name => $path) {
			$list [] = basename($name, $ext);
		}
		//$status['filtered'] = count($fileList) - count($filteredList);
	}
}
return kmod_api::response(array(
	'options' => $list,
	//'status' => $status,

	'post' => array(
		'name' => $name
	),
));
