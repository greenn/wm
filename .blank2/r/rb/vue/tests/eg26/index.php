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
    <div id="el"></div>

    <!-- using string template here to work around HTML <option> placement restriction -->
    <script type="text/x-template" id="demo-template">
        <div>
            <p>Selected: {{ selected }}</p>
            <select2 :options="options" v-model="selected">
                <option disabled value="0">Select one</option>
            </select2>
        </div>
    </script>

    <script type="text/x-template" id="select2-template">
        <select>
            <slot></slot>
        </select>
    </script>

<?//=js::html_link($Self::uri("$relDir/app.js.php"))?>
<script><?=$Self::tpl("$relDir/app", false, 'js.inc')?></script>

<?###################################################
$body = ob_get_clean();

$Self::req_css("$relDir/styles");
//$Self::req_css("$relDir/app");
css::req(false, 'https://unpkg.com/select2@4.0.3/dist/css/select2.min.css');
js::req(false, 'https://unpkg.com/select2@4.0.3/dist/js/select2.js');

print rb_tpl('page', 'page', array(
	'body' => $body,
	'webkit' => array(
        'jquery', 'lodash',
        //'llog',
        'vue', array('vue-init', 'Editor')
    ),
));
