<?
$dbCtx = isset($_ctx) ? $_ctx : array();


$struct = array(
	'key' => array('auto-id', 'small'),
	'agent' => array('str'),
);


return array(
	'struct' => $struct,
);