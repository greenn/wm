<?

include_once $_SERVER['DOCUMENT_ROOT'] . '/site/iq.inc';

need_rp('aos');



if (!1 && 'reset aos_set') {
	$prev = aos_set();
	aos_set(null);
	dx(aos_set(), $prev);
}

if (!1 && 'aos_') {
	d(aos_set("fade-down ease-out-cubic"), aos_());
}


if (!!1 && 'aos_') {

	/* работает - ок
		$a = array('a' => 1, 'b' => 2);
		d($key = key($a));
		unset($a[$key]);
		dx(key($a), $a);
	*/

	//dx(aos_set(150, 0));

	aos_set("fade-down ease-out-cubic", $t = 200, $d = 100);

	d(
		//aos_(),
		aos_($t + 50, 0)
	);
}
