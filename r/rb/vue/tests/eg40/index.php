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
//vue::req('login-form', $selfName, "$relDir/login-form/cmpt");
?>

    <div id="app">
        <input v-model.number="firstNumber" type="number" step="20"> +
        <input v-model.number="secondNumber" type="number" step="20"> =
        {{ result }}
        <p>
            <animated-integer :value="firstNumber"></animated-integer> +
            <animated-integer :value="secondNumber"></animated-integer> =
            <animated-integer :value="result"></animated-integer>
        </p>
    </div>


<?//=js::html_link($Self::uri("$relDir/app.js.php"))?>
<script><?=$Self::tpl("$relDir/app", false, 'js.inc')?></script>

<?###################################################
$body = ob_get_clean();

$Self::req_css("$relDir/styles");
js::req(false, 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.2.4/gsap.min.js');

print rb_tpl('page', 'page', array(
	'body' => $body,
	'webkit' => array(
        //'jquery', 'lodash',
        //'llog',
        'vue', array('vue-init', 'Editor')
    ),
));
