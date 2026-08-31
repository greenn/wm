<?
$Self = _kot::self();
$n = $Self::nc();
$nC = $Self::nc('content');

$_ctx = $Self::tempCtx(array(
	'baseUri' => '',
));


$baseUri = $_ctx['baseUri'];

$appOpt = '';
if ($baseUri) $appOpt = "?base=".urlencode($baseUri);

$Self::req_css('kot-app');
$Self::req_js(1, 'app-env');
$Self::req_js(3, 'app'.$appOpt);

$Self::req_vue('sys-msg');
_kot::req_vue('app-side');
_kot::req_vue('app-head');
_kot::req_vue('app-head', 'head-cmd');

_kot::req_vue('login', 'login-page');


_kot::req_vue('ui', 'lay/lay-section', array(), 'lay-section'); //mbd kot('ui', 'req_vue_name', 'lay-section');

?>
<login-page v-if="isLogined"></login-page>

