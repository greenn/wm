<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$list = mc::item_all('sd', 'sd');
d($list);


foreach ($list as $data) {
	$name = $data['sd'];
	$type = $data['type'];
	$cfg = json_decode($data['cfg'], true);
	d($name, $type, $cfg);
}


