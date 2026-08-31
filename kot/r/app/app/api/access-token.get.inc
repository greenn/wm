<?

_needphp('x.class/_x'); //dbg

$origin = prop(rt_api::$CORS, 'origin');
if ($originList = _prop(rt_api::$CORS, 'origin-list')) {
	if (in_array(@$_SERVER['HTTP_ORIGIN'], $originList)) {
		$origin = $_SERVER['HTTP_ORIGIN'];
	}
}
//d(rt_api::$CORS);
return kot_api::response(array(
	//'cors' => @$origin,
	//'origin-list' => @$originList,
	//'Access-Control-Allow-Origin' => $origin,
	//'headers' => apache_response_headers(),
	//'headers-list' => headers_list(),
	'sid' => session_id(),
	'origin' => @$_SERVER['HTTP_ORIGIN'],
	'access_token' => _s('access_token')
));