<?

_needphp(
	'strLess'
);

$Self = _kot::self();
$n = $Self::nc();




$_ctx = $Self::tempCtx(array(
    'vue' => '',
    'body' => false,
    'mount' => false,
));
$vueCtx = $_ctx['vue'];
$body = $_ctx['body'];
$mount = $_ctx['mount'];

if ($vueCtx) {
    $body = $Self::tpl('vue-tag', $vueCtx);
}


$appOpt = '';
if ($mount) {
	$appOpt = '?'.'mount='.urlencode($mount);
}

$Self::req_js(1, 'app-env');
$Self::req_js('app'.$appOpt);
$Self::req_css('app'); //ak test-app

print kot_tpl('app', 'page', array(
	'body' => $body
));