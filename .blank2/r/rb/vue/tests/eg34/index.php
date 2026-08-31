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
    <div id="flip-list-demo">
        <button @click="shuffle">Shuffle</button>
        <transition-group name="flip-list" tag="ul">
            <li v-for="item in items" :key="item">
                {{ item }}
            </li>
        </transition-group>
    </div>



<?//=js::html_link($Self::uri("$relDir/app.js.php"))?>
<script><?=$Self::tpl("$relDir/app", false, 'js.inc')?></script>

<?###################################################
$body = ob_get_clean();

$Self::req_css("$relDir/styles");
//js::req(false, 'https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js');

print rb_tpl('page', 'page', array(
	'body' => $body,
	'webkit' => array(
        'jquery', 'lodash',
        //'llog',
        'vue', array('vue-init', 'Editor')
    ),
));
