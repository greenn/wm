<?
$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
	'login' => '',
	'password' => '',
));

$cur_token = _s('access_token'); //dbg

$login = $_ctx['login'];
$pass = $_ctx['password'];

$access_token = '';
if ($login === 'avokado') {
	$access_token = md5($login.$pass);
	_s('access_token', $access_token);

}

return kot_api::response(array(
	'headers' => apache_response_headers(),
	'sid' => session_id(),
	'prev_token' => $cur_token,
	'access_token' => $access_token,
));