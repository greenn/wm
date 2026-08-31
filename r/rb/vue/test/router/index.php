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
$Self::vue_req('v-cmpt', "$relDir/cmpt");
$Self::vue_req('page-404', "$relDir/custom");
$Self::vue_req('v-menu', "$relDir/v-menu");
ob_start();
####################################################
?>
<h1>{{h1}}</h1>
<v-menu></v-menu>

<main>
    <router-view v-slot="{ Component }">
        <keep-alive>
            <component :is="Component" />
        </keep-alive>
    </router-view>
</main>

<h3>footer-test</h3>
<v-cmpt></v-cmpt>
<page-404></page-404>

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
