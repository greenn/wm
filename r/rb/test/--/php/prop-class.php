<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

_needphp('prop.class');

$data = array(
	'a1' => array(
		'a2' => 10
	),
	'b' => 'b100',
	'c' => 'c100',
);

d(_prop($data, 'c'));
d(_prop($data, ['b']));
d(_prop($data, ['a1', 'a2'])); //10

d(_prop::get_($data, 'a1', 'a2')); //10

d(_prop::pikIn($data, 'a1', 'a2')); //10
d(_prop::pikIn($data, 'a1', array('a2'))); //10
d(_prop::pikIn($data, 'a1', array('a3', 'a2'))); //10

//d($data = _prop::set($data, ['a1', 'a3'], 12));
d(_prop::update($data, ['a1', 'a3'], 12));
d(_prop::pikIn($data, 'a1', array('a3', 'a2'))); //10
d(_prop::unset($data, ['a1', 'a2']));
d(_prop::pikIn($data, 'a1', array('a3', 'a2'))); //12


d(_prop::set(false, ['a1', 'a2'], 11));
d(_prop::set($data, ['a1', 'a2'], 11));