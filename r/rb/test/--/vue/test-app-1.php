<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
ob_start();
?>
    <script>

        const VueApp = Vue.createApp({
            data: function(){
                //_log('data', { attrs: this.$attrs });
                return {
                    headline: 'Заголовок',
                }
            },
        });

        /*var VueCmpt1 = _vue('cmpt1', function(_log, _cmd){
            return  {
                data: function(){
                    //_log('data', { attrs: this.$attrs });
                    return {
                        headline: 'Заголовок 2',
                    }
                },

            }
        })
        var cVueCmpt1 = VueApp.component('modal1', VueCmpt1);
        */
    </script>


    <style type="text/css">

    </style>

    <div id="test-app">
        <div>== {{ headline }}</div>
    </div>

    <script>
        var $VueApp = VueApp.mount('#test-app');
    </script>


<?
$body = ob_get_clean();

print rb_tpl('page', 'page', array(
	'pageTitle' => 'vue: test - app',
	'body' => $body,
	'webkit' => array(
		'vue-env'
	),
));