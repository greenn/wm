<?
$struct = array(
	'id' => array('auto-id', 'int+4'),
	'title' => array('128'),
	'name' => array('128'),
	'uri-auto' => array('bool'),
	'uri' => array('64'),
	'parent' => array('int+4'),
	'prm' => array('256'),
);

$data = array();

$data[1] = array(//1
	'title' => 'SEO',
	'name' => 'seo',
	'uri-auto' => true,
	'parent' => '0',
);

$data[2] = array(//2
	'title' => 'robots.txt',
	'name' => 'robots-txt',
	'uri-auto' => true,
	'parent' => '1',
);

$add = array(
	'Site', 'site', array(
		array('admin', 'site-admin'),
		array('r', 'site-r'),
	),
	'Kot', 'kot', array(
		array('admin', 'kot-admin'),
		array('r', 'kot-r'),
	)
);

//foreach ($add as $)
return array(
	'struct' => $struct,
	'data' => $data,
	/*'data-opt' => array(
		'add_verify_prop' => 'id'
	)*/
);