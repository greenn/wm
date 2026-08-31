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
                            title: 'cmpt-title',
                        };
                    },
                    methods: {
                        updateData() {
                            // Здесь выполняется AJAX-запрос
                            // После получения данных
                            this.title = 'cmpt-title 2';
                        }
                    },
                    mounted: function(){
                        //this.fetchData();
                    }
                }
            },

        });

	</script>

	<div id="app">

        <pre>title: {{ title }}</pre>

		<ui-custom v-model:value="title"></ui-custom>
		<ui-field v-model:value="title"></ui-field>

        <button @click="updateData">Обновить данные</button>
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