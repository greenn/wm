<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

_needphp('fq/pickProps');


$data = array(
	'a' => array(
		'b' => array(
			'c' => 111
		)
	)
);

$path = array('a', 'b');

if (1) dx(
	pickProps('a', $data),
	pickProps(1, $path)
);

