<?
/*
	api/rw/tool-admin/sd/list
	api/rw/tool-admin/sd/list?sd=user-type&resProp=id
*/

$Self = _rw::name('tool-admin');
$_ctx = $Self::tempCtx(array(
	'sd' => false,
	'resProp' => false,
));

$resByProp = $_ctx['resProp'];
$sdName = $_ctx['sd'];
//dx($sdName, $resByProp);

$list = null;
if ($sdName) {
	$list = _sd($sdName)->all($resByProp);
}


return array('list' => $list);