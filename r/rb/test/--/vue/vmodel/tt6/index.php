<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_rb::need('vue');

ob_start();
?>
	<script>
        var _log = Log.for('DBG');

        VueRoot.root.init({
            mount: '#app',

            decl: function(_log){
                return {
                    data() {
                        return {
                            pageTitle: 'pageTitle'
                        };
                    },
                }
            },

        });

	</script>

	<div id="app">

        <ui-field
                v-model="pageTitle"
	        <? if (0) { ?>
                :modelValue="pageTitle"
                @update:modelValue="pageTitle = $event"

                v-model:title="pageTitle"
                <?// ~ === ?>
                :title="pageTitle"
                @update:title="pageTitle = $event"
	        <? } ?>
        ></ui-field>

        <? if (0) { ?>
            <ui-field :value="pageTitle" @input="pageTitle = $event" ></ui-field>
        <? } ?>
        <p>Field Value: {{ pageTitle }}</p>
	</div>

    <?=vue_source_html(dirname(__FILE__).'/ui-field', true)?>
    <?//=vue_source_html(dirname(__FILE__).'/ui-custom', true)?>

<?
$_body = ob_get_clean();

print rb_tpl('page', 'page', array(
	'body' => $_body,

	'pageTitle' => 'VUE OFF',

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