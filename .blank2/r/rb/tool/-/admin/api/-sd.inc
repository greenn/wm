<?
//q операции s sd таблицами

$Self = _rw::name('tool-admin');
$_ctx = $Self::tempCtx(array(
	'sd' => false,
));
$sdName = $_ctx['sd'];
dx($sdName);


return array('ok' => basename(__FILE__, '.inc'));