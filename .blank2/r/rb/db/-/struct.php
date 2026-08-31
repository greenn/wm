<?#0.6.1

_needphp('dirToArray.class');

$dbStruct = array();
$tb_list = array();


$dbDir = dirname(dirname(__FILE__)).'/config/db';
//dx($dbDir);

$dbCtx = array();
$dbCtxPath = $dbDir.'.inc';
if (is_file($dbCtxPath)) {
	$dbCtx = inc_data($dbCtxPath, array());
	//dx($dbCtx);
}



$fileList = dirToArray::apply(array(
	'path' => $dbDir,
	'keepDots' => false,
	'depth' => 0,
));
$fileList = dirToArray::excludePath($fileList, array(
	'endsWith' => '-',
	'startsWith' => array('-', '.'),
));
//dx($fileList);

//dx($fileList, array_keys($fileList));
$tb_list = array_keys($fileList);

foreach ($tb_list as &$name) {
	$name = basename($name, '.inc');
}

//dx($tb_list, $fileList, is_dir($dbDir), $dbDir);


//dx($tb_list);
//if (!is_array($dbStruct)) $dbStruct = array();

foreach ($tb_list as $tbName) {
	$dbStruct[$tbName] = inc_data("$dbDir/$tbName.inc", $dbCtx);
}

//dx($dbStruct);

return $dbStruct;
