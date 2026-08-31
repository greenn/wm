<?
_needphp('dirToArray.class');

$Self = _kot::self();
//$status = array(); //для msg-pane

$_ctx = $Self::tempCtx(array(
	'name' => '',
));
$name = $_ctx['name'];



$list = array();

$path = '';
$ext = '';
switch ($name) {
	case 'kmod': {
		$path = $GLOBALS['KOT']->dirRoot.'/r/mod';
	} break;
}

//oo kot/r/mod/guzzler/api/get-select.get.inc

if ($path) {
	$fileList = dirToArray::apply(array(
		'path' => $path,
		'keepDots' => false,
		'depth' => 0,
	));
}

switch ($name) {
	case 'kmod': {
		foreach ($fileList as $name => $path) {
			if (is_dir($path)) {
				$list []= $name;
			}
		}
	} break;
}

return kmod_api::response(array(
	'options' => $list,
	//'status' => $status,

	'post' => array(
		'name' => $name
	),
));
