<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
$Self = _site::self();
$response = array();

$_ctx = $Self::tempCtx(array(
	'text' => '',
));

$query = $_ctx['text'];

return site_api::response(array(
	'result' => 2,
	'query' => $query,
));

//return site_api::response($ok);