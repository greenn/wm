<?#5-2/3.3.116
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
    'strLess'
);

$Self = _rb::self();
$relDir = pathLess(dirname(__FILE__), $Self->path('/'));

//$Self::req_vue("$relDir/cmpt", 'v-cmpt');
$Self::vue_req('v-cmpt', "$relDir/cmpt");
$Self::req_css("$relDir/styles");
//$Self::req_js("$relDir/-app");

ob_start();
####################################################
?>

<v-cmpt></v-cmpt>

<v-cmpt>
    кнопка
</v-cmpt>

<?###################################################
$body = ob_get_clean();


print rb_tpl('page', 'page', array(
	'body' => $Self::vue_test($body, true),
	//'body' => $body,
	'webkit' => array(
		'vue-env',
    ),
));
