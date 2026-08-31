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
        <svg width="200" height="200">
            <polygon :points="points"></polygon>
            <circle cx="100" cy="100" r="90"></circle>
        </svg>
        <label>Sides: {{ sides }}</label>
        <input type="range" min="3" max="500" v-model.number="sides" />
        <label>Minimum Radius: {{ minRadius }}%</label>
        <input type="range" min="0" max="90" v-model.number="minRadius" />
        <label>Update Interval: {{ updateInterval }} milliseconds</label>
        <input type="range" min="10" max="2000" v-model.number="updateInterval" />
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
