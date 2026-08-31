<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
/*
	oo php/_s/sp.class.php

*/
_needphp('_s/init');

$nm = 'test-data';
$data = array('a' => array(
	'b' => array(
		'c' => 111
	)
));

_s('test-data', $data);

if (1) {
	_s('test-data', array());
	s::prop_push(array($nm), 45);
	s::prop_push(array($nm), 47);
	s::prop_push(array($nm), 47, 'a');
	s::prop_del(array($nm, 'a'));
	dx(_s('test-data'));
}

if (1) dx(
	_s('test-data'),
	s::prop_merge(array($nm, 'a', 'b'), array('d' => 44)),
	s::prop_push(array($nm, 'a', 'b'), 45, 'e'),
	_s('test-data'),
1);

if (1) dx(
	_s('test-data'),
	s::prop_push(array($nm, 'a', 'b', 'c'), 100),
	s::prop_push(array($nm, 'a', 'b', 'c'), 111),
	_s('test-data'),
1);

if (1) dx(
	_s('test-data'),
	s::prop_del(array($nm, 'a', 'b')),
	_s('test-data'),
1);

if (1) dx(
	s::prop_has(array($nm, 'a', 'b')),
	_sp(true, array($nm, 'a', 'b')),
	_sp(true, array($nm, 'b', 'a')),
1);


