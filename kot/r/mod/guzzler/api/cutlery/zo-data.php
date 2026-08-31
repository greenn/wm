<?
_needphp('isAssoc');

$set;
$opt;
$jsonData; // пришедшие json-данные

$status['zo'] = 'ням-ням';

//$keyName = _prop($set, 'salt');
//dx($target);

$list = array();

foreach ($jsonData as $filename => $item) {

	$num = basename($filename, '.jpg');

	if (preg_match('/^п(\d+)$/', $num, $matches)) {
		$num = $matches[1];
		$target = 'krestovskoe2';
		$status['сосед'] = '2';
	}

	$item['pics'] = array(
		array('filename' => $filename)
	);


	$list[$num] = $item;
}

$status['нумс'] = array_keys($list);
//dx($list, $jsonData);
$jsonData = $list;


$_mergeDeep = true;
$_kSort = true;

