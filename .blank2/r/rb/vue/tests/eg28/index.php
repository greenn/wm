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
    <script type="text/x-template" id="header-view-template">
        <div class="draggable-header-view"
             @mousedown="startDrag" @touchstart="startDrag"
             @mousemove="onDrag" @touchmove="onDrag"
             @mouseup="stopDrag" @touchend="stopDrag" @mouseleave="stopDrag">
            <svg class="bg" width="320" height="560">
                <path :d="headerPath" fill="#3F51B5"></path>
            </svg>
            <div class="header">
                <slot name="header"></slot>
            </div>
            <div class="content" :style="contentPosition">
                <slot name="content"></slot>
            </div>
        </div>
    </script>

    <div id="app" @touchmove.prevent>
        <draggable-header-view>
            <template v-slot:header>
                <h1>Elastic Draggable SVG Header</h1>
                <p>
                    with <a href="http://vuejs.org">Vue.js</a> +
                    <a href="http://dynamicsjs.com">dynamics.js</a>
                </p>
            </template>
            <template v-slot:content>
                <p>
                    Note this is just an effect demo - there are of course many
                    additional details if you want to use this in production, e.g.
                    handling responsive sizes, reload threshold and content scrolling.
                    Those are out of scope for this quick little hack. However, the idea
                    is that you can hide them as internal details of a Vue.js component
                    and expose a simple Web-Component-like interface.
                </p>
            </template>
        </draggable-header-view>
    </div>


    <?//=js::html_link($Self::uri("$relDir/app.js.php"))?>
<script><?=$Self::tpl("$relDir/app", false, 'js.inc')?></script>

<?###################################################
$body = ob_get_clean();

$Self::req_css("$relDir/styles");
js::req(false, 'https://unpkg.com/dynamics.js@1.1.5/lib/dynamics.js');

print rb_tpl('page', 'page', array(
	'body' => $body,
	'webkit' => array(
        'jquery', 'lodash',
        //'llog',
        'vue', array('vue-init', 'Editor')
    ),
));
