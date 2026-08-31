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
    <!-- template for the polygraph component. -->
    <script type="text/x-template" id="polygraph-template">
        <g>
            <polygon :points="points"></polygon>
            <circle cx="100" cy="100" r="80"></circle>
            <axis-label
                    v-for="(stat, index) in stats"
                    :stat="stat"
                    :index="index"
                    :total="stats.length">
            </axis-label>
        </g>
    </script>

    <!-- demo root element -->
    <div id="demo">
        <!-- Use the component -->
        <svg width="200" height="200">
            <polygraph :stats="stats"></polygraph>
        </svg>
        <!-- controls -->
        <div v-for="stat in stats">
            <label>{{stat.label}}</label>
            <input type="range" v-model="stat.value" min="0" max="100" />
            <span>{{stat.value}}</span>
            <button @click="remove(stat)" class="remove">X</button>
        </div>
        <form id="add">
            <input name="newlabel" v-model="newLabel" />
            <button @click="add">Add a Stat</button>
        </form>
        <pre id="raw">{{ stats }}</pre>
    </div>

    <p style="font-size:12px">* input[type="range"] requires IE10 or above.</p>



<?//=js::html_link($Self::uri("$relDir/app.js.php"))?>
<script><?=$Self::tpl("$relDir/app", false, 'js.inc')?></script>

<?###################################################
$body = ob_get_clean();

$Self::req_css("$relDir/styles");
//js::req(false, 'https://unpkg.com/dynamics.js@1.1.5/lib/dynamics.js');

print rb_tpl('page', 'page', array(
	'body' => $body,
	'webkit' => array(
        'jquery', 'lodash',
        //'llog',
        'vue', array('vue-init', 'Editor')
    ),
));
