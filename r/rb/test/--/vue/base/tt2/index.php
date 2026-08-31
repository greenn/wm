<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
ob_start();

_rb::need('vue');
?>

	<script>
        var _log = Log.for('DBG');

        VueRoot.root.init({
            mount: '#app',

            decl: function(_log){
                return {
                    data() {
                        return {
                            isChecked: false,
                            inputValue: ''
                        };
                    },
                    methods: {},
                    mounted: function(){}
                }
            },

        });

	</script>

	<div id="app">

        <div>
            <checkbox-field :is-checked.sync="isChecked"></checkbox-field>
            <p>Is Checked: {{ isChecked }}</p>
        </div>

        <ui-field :value.sync="inputValue"></ui-field>
        <p>Input Value: {{ inputValue }}</p>

	</div>

    <?=vue_source_html(dirname(__FILE__).'/checkbox-field', true)?>
    <?=vue_source_html(dirname(__FILE__).'/ui-field', true)?>

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