<?
$dbCtx = isset($_ctx) ? $_ctx : array();

$struct = array(
	'uid' => $dbCtx['uid-struct'],
	'log_json' => array('long'),
	'last_update' => array('datetime'),
);

return array(
	'struct' => $struct,
);