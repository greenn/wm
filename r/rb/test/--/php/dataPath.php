<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
/*
	oo php/_s/sp.class.php

*/
_needphp('dataPath.class');


$data = array('a' => array(
	'b' => array(
		'c' => 111
	)
));

$path = array('a', 'b');

if (1) dx(
	dataPath::has($data, array('c') + $path), dataPath::error_info(),
	dataPath::has($data, $path),
	dataPath::get($data, $path),
	dataPath::set($data, $path, 10),
	dataPath::del($data, $path),
	dataPath::push($data, $path, 100),
	dataPath::merge($data, $path, array('d' => 45)),
1);

