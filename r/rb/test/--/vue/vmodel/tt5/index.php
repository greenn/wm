<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
ob_start();

_rb::need('vue');

js::req(-1, false, false, 'console.log(11)');


//vue::req(false, false, 'ui-input', 'ui-input', '/iq/test/js/vue/tt1');
//oo iq/php/source.class.php:303
?>

	<script>
        var _log = Log.for('DBG');

        VueRoot.root.init({
            mount: '#app',

            decl: function(_log){
                return {
                    data() {
                        return {
                            inputValue: 'Initial Value'
                        };
                    },
                }
            },

        });

	</script>

	<div id="app">

        <div>
            v-model
            <input v-model="inputValue" />
        </div>
        <div>
            :value
            <input :value="inputValue" />
        </div>
        <ui-custom v-model:field-value="inputValue"></ui-custom>
        <p>Field Value: {{ inputValue }}</p>
	</div>

    <?=vue_source_html(dirname(__FILE__).'/ui-field', true)?>
    <?=vue_source_html(dirname(__FILE__).'/ui-custom', true)?>

<?
$_body = ob_get_clean();

print rb_tpl('page', 'page', array(
	'body' => $_body,

	'pageTitle' => 'VUE TT1',

	'raw-source' => join(newline2, array(
		'<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">',
		'<link type="text/css" rel="stylesheet" href="/r/rb/lay/flex.css.php" />',
		'<link type="text/css" rel="stylesheet" href="/r/rb/css/aq.css.php" />',
	)),

	'webkit' => array(
		'vue-env-2',
		//'vuex',
	),
));