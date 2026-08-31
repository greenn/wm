<?#5-2/3.3.116
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
    'strLess'
);

$Self = _rb::self();
$relDir = pathLess(dirname(__FILE__), $Self->path('/'));
//dx($relDir);
$selfName = $Self::cfg('rName');


vue::req('login-form', $selfName, "$relDir/login-form/cmpt");
dx(new vue);

ob_start();
####################################################
vue::req('login-form', $selfName, "$relDir/login-form/cmpt");
?>
<div id="app">
    <div>
        <h1>Hello Vue!</h1>
        <LoginForm :onLogin='onLogin' />
    </div>
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
