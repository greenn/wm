<?
_needphp('json');

$Self = _kmod::self();

$_ctx = $Self::tempCtx(array(
	'food' => '',
));

dx($_ctx);
$food = $_ctx['food'];

$json = jsonTryDecode($food);
if (is_string($json)) {
	$food = "[$food]";
	$json = jsonTryDecode($food);
}

return kmod_api::response(array(
	'food' => $food,
	'json' => $json,
	'json-error' => jsonLastErrorMsg(),
));