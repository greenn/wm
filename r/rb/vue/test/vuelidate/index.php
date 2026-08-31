<?
/*
    https://www.youtube.com/watch?v=c2SK1IlmYL8
*/
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$Self = _rb::self();
$relDir = $Self::relDir();
//dx($relDir, $Self::relName());

//$Self::vue_req('v-cmpt', "$relDir/cmpt");
$Self::req_css("$relDir/styles");
$Self::req_js("$relDir/app");

ob_start();
####################################################
?>
<h1>{{h1}}</h1>

<?###################################################
$body = ob_get_clean();
$body = "<div id=\"app\">$body</div>";


print rb_tpl('page', 'page', array(
	//'body' => $Self::vue_test($body, true),
	'body' => $body,
	'webkit' => array(
		'vue-env',
		'fas',
    ),
));
