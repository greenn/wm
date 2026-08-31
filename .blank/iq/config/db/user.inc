<?
$dbCtx = isset($_ctx) ? $_ctx : array();


$struct = array(
	'uid' => $dbCtx['uid-struct'],
	'ip_list' => array('text'),
	'browser_list' => array('text'),
	//'browser_list_json' => array('text'),
	'timelog_qlist' => array('text'),
	'auth' => array('bool', array('def' => 0)),
);


return array(
	'struct' => $struct,
);