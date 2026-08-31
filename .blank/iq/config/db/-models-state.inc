<?
$struct = array(
	'id' => array('auto-id', 'int-4'),
	//'user_id' => array('25', 'unique'),
	//'pdf_id' => array('25', 'unique'),
	'user' => array('25'),
	'pdf_name' => array('int-4'),
	'state' => array('25'),
	'price' => array('10'),
	'price_type' => array('15'),
);

//$struct = array('sd', 'multi-value', $struct);

$data = array();

return array(
	'struct' => $struct,
	//'data' => $data,
);