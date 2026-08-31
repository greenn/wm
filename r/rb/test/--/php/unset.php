<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$ar = array('1', 'b', array('c', '2'), 'e');

unset($ar[2]);

d($ar, array_values($ar));

$ar = array('1', 'b', array('c', '2'), 'e');
foreach ($ar as $index => $value) {
	//d($index, $value);
	if (isOrdinal($value)) {
		unset($ar[$index]);
		$ar = array_merge($ar, $value);
	}
}

d($ar);