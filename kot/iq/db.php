<?
//ak db-struct

_needphp('dirToArray.class');

$dbStruct = array();
$db_list = array();


$dbDir = dirname(__FILE__).'/db';

$fileList = dirToArray::apply(array(
	'path' => $dbDir,
	'keepDots' => false,
	'depth' => 1,
));
$fileList = dirToArray::excludePath($fileList, array(
	'endsWith' => '-',
	'startsWith' => '-',

));
//dx($fileList);

//dx($fileList, array_keys($fileList));
$db_list = array_keys($fileList);

foreach ($db_list as &$name) {
	$name = basename($name, '.inc');
}

//dx($db_list, $fileList, is_dir($dbDir), $dbDir);


//dx($db_list);
//if (!is_array($dbStruct)) $dbStruct = array();

foreach ($db_list as $tbName) {
	$dbStruct[$tbName] = inc_data("$dbDir/$tbName.inc");
}

//dx($dbStruct);

return $dbStruct;
