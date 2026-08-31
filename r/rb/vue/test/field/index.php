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

<script type="text/x-template" id="v-field">
    <div>
        <div>VField / {{ title }} / <slot></slot></div>
        <label>
            <input v-model="item.value" :disabled="item.disabled" />
        </label>
        <pre>{{ item }}</pre>
    </div>
</script>
<script >
    const VField = {
        template: '#v-field',
        props: ['item', 'title'],
        methods: {
            toggleDisabled: function(item){
                item.disabled = !item.disabled;
            },
        },
        render: function () {

            //const ButtonCounter = Vue.resolveComponent('VField')
            return Vue.h(this.$el)

            //return Vue.h()
        }
    }
</script>
<div id="app">
    <div class="row" v-for="(item, index) in fields">
		<v-field v-bind:item="item" title="VField'">VField*</v-field>
        <div>
            <label>
                <input v-model="item.value" :disabled="item.disabled" />
            </label>
            <button @click="toggleDisabled(item)">toggleDisabled</button>
        </div>
    </div>

    <button @click="showValues()">showValues</button>
    <pre>{{ fields }}</pre>
</div>



<?//=js::html_link($Self::uri("$relDir/app.js.php"))?>
<script><?=$Self::tpl("$relDir/app", false, 'js.inc')?></script>

<?###################################################
$body = ob_get_clean();

$Self::req_css("$relDir/styles");

print rb_tpl('page', 'page', array(
	'body' => $body,
	//'head' => array(),
	'webkit' => array(
        //'lodash',
        'jquery', 'lodash',
        //'llog',
        'vue',
        //array('vue-init', 'Editor')
    ),
));
