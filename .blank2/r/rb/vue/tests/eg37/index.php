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

    <div id="dynamic-fade-demo" class="demo">
        Появление:
        <input type="range" v-model="fadeInDuration" min="0" :max="maxFadeDuration" />
        Исчезновение:
        <input
                type="range"
                v-model="fadeOutDuration"
                min="0"
                :max="maxFadeDuration"
        />
        <transition
                :css="false"
                @before-enter="beforeEnter"
                @enter="enter"
                @leave="leave"
        >
            <p v-if="show">привет</p>
        </transition>
        <button v-if="stop" @click="stop = false; show = false">
            Начать анимацию
        </button>
        <button v-else @click="stop = true">Остановить!</button>
    </div>


<?//=js::html_link($Self::uri("$relDir/app.js.php"))?>
<script><?=$Self::tpl("$relDir/app", false, 'js.inc')?></script>

<?###################################################
$body = ob_get_clean();

$Self::req_css("$relDir/styles");
js::req(false, 'https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js');

print rb_tpl('page', 'page', array(
	'body' => $body,
	'webkit' => array(
        //'jquery', 'lodash',
        //'llog',
        'vue', array('vue-init', 'Editor')
    ),
));
