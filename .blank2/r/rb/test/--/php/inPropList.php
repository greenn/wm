<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

_needphp('fq/inPropList');


$data = array(
	'a' => array(
		'b' => array(
			'c' => 111
		)
	)
);

$path = array('a', 'b');

if (1) dx(
	inPropList('pre', $data),
	inPropList('pre', $path)
);

