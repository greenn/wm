<?
$Self = _kot::self();

//_s(null, $Self::$nsSideState);
$sideState = _s(true, $Self::$nsSideState, true);
//dx($Self::$nsSideState, $sideState, _s($Self::$nsSideState));

$reverseValue = !$sideState;
$newState = _s($Self::$nsSideState, $reverseValue);

return kot_api::response(array(
	'state' => $newState
));