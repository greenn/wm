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
                            title: '22',
                            fields: {
                                title: '33'
                            }
                        };
                    },
                    methods: {
                        fetchData() {
                            // Здесь выполняется AJAX-запрос
                            // После получения данных
                            this.title = 'Новый заголовок 2';
                            this.fields.title = 'Новый заголовок 1';
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

        <pre>{{ fields }}</pre>

		<ui-input v-model:value="fields.title"></ui-input>

        <button @click="fetchData">Загрузить данные</button>
	</div>

    <?=vue_source_html(dirname(__FILE__).'/ui-input', true)?>

<?
$_body = ob_get_clean();

print rb_tpl('page', 'page', array(
	'body' => $_body,

	'pageTitle' => 'VUE TT1',

	'raw-source' => join(newline2, array(
		'<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">',
	)),

	'webkit' => array(
		'vue-env-2',
		//'vuex',
	),
));