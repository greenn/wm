<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
echo '<pre>';
print jsonPrettyEncode(array(
	1 => 'aaa',
	'2' => 'bbb',
	'c' => 3,
	'd' => '4',
));