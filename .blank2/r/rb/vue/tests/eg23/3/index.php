    <?#5-2/3.3.116
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
    'strLess'
);

$Self = _rb::self();
$relDir = pathLess(dirname(__FILE__), $Self->path('/'));
//dx($relDir);
$selfName = $Self::cfg('rName');



ob_start();
####################################################
vue::req('login-form', $selfName, "$relDir/login-form/cmpt");
?>
<div id="app">
    <?//<login-form @login='onLogin'></login-form>?>
    <?//<login-form :onLogin='onLogin2' />?>
    <?//<login-form :onLogin='onLogin2' />?>
    <login-form @emit-login="doLogin" />
</div>

<?//=js::html_link($Self::uri("$relDir/app.js.php"))?>
<script><?=$Self::tpl("$relDir/app", false, 'js.inc')?></script>

<?###################################################
$body = ob_get_clean();
$Self::req_css("$relDir/styles");

print rb_tpl('page', 'page', array(
	'body' => $body,
	'webkit' => array(
        'jquery', 'lodash',
        //'llog',
        'vue', array('vue-init', 'Editor')
    ),
));
