<?#3.3.1
/*
	 oo
		rb/wd-/wd.tpl.php
*/
$Self = _rb::self();
$typeMap = $Self::$typeMap;

$Self::req_css("cmd");
$Self::req_js("wd");
js::req_name('jquery', 'lodash', 'w-storage');


$_ctx = $Self::tempCtx(array(
	'v' => 'def',
	//'src' => false,
	//'preset' => false,
	'embody' => '',
	'just-embody' => false,
));

$wd_v = $_ctx['v'];
$wd_tpl = prop($typeMap, $wd_v, $typeMap['def']);

//dx($wd_tpl, $_ctx);

if ($_ctx['just-embody']) {
	$_wd = $_ctx['embody'];
} else {
	//base case
	$_wd = $Self::tpl($wd_tpl, $_ctx);
}

print $_wd;
