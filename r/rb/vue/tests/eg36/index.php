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
    <div id="demo">
        <input v-model="query" />
        <transition-group
                name="staggered-fade"
                tag="ul"
                :css="false"
                @before-enter="beforeEnter"
                @enter="enter"
                @leave="leave"
        >
            <li
                    v-for="(item, index) in computedList"
                    :key="item.msg"
                    :data-index="index"
            >
                {{ item.msg }}
            </li>
        </transition-group>
    </div>


<?//=js::html_link($Self::uri("$relDir/app.js.php"))?>
<script><?=$Self::tpl("$relDir/app", false, 'js.inc')?></script>

<?###################################################
$body = ob_get_clean();

$Self::req_css("$relDir/styles");
js::req(false, 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.3.4/gsap.min.js');

print rb_tpl('page', 'page', array(
	'body' => $body,
	'webkit' => array(
        'jquery', 'lodash',
        //'llog',
        'vue', array('vue-init', 'Editor')
    ),
));
