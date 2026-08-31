<?
/*
	api/rw/tool-admin/sd/struct?sd=user-type
	api/rw/tool-admin/sd/struct?sd=user-type&get=fields
*/

$Self = _rw::name('tool-admin');


$_ctx = $Self::tempCtx(array(
	'sd' => false,
	'get' => false,
));

$sdName = $_ctx['sd'];
$resProp = $_ctx['get'];
//dx($sdName);

//$struct = _sd::info_get($sdName);
$struct = _sd::struct_info($sdName, $resProp);

return array('struct' => $struct);