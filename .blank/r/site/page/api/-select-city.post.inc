<?
//внутренний api-вызов
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
$Self = _site::self();
$response = array();

$_ctx = $Self::tempCtx(array(
	'title' => '',
));

//$curState = _s(false, $Self::$nsCityState, _pro('contacts', 'city-def'));
//$curState = site('page', 'curCityCid')
//dx($curState, 'has-ns', _s(true, $Self::$nsCityState), _pro('contacts', 'city-def'));

$ok = false;
$cityTitle = $_ctx['title'];
foreach (_pro('contacts', 'city-list') as $cityId => $city) {
	if ($cityTitle === $city[0]) {
		_s($Self::$nsCityState, $cityId);
		$ok = true;
	}
}

return site_api::response(array(
	'cur-state' => _s($Self::$nsCityState),
	'success' => $ok,
));

//return site_api::response($ok);