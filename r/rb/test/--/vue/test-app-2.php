<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
ob_start();
?>

    <style type="text/css">

    </style>

    <div id="test-app">
        <div>222</div>
        <div>== {{ headline }}</div>
    </div>



    <script>
        _vue.autoinit = true;
        vue_app(function(_log){
            return {
                data: function(){
                    //_log('data', { attrs: this.$attrs });
                    return {
                        headline: 'Заголовок',
                    }
                },

                mounted: function() {
                    _log('MOUNTED');
                }
            }

        }, function(_log){
            //_log('.. _vue app III');
            App = _App.mount('#test-app'); //+
            //App = _App.mount($('BODY')[0]); //+
            //App = _App.mount('BODY'); //+
            _log('.. _vue app IV', { App, _App });
        })


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