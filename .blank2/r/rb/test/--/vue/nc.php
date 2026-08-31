<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
ob_start();
?>
    <style type="text/css">
        SECTION {
            width: 150px;
            height: 50px;
            background-color: grey;
        }
        .-a { border: 2px solid red; }
        .-b { background-color: blue; }
        .-c:after { content: '-' }
    </style>

    <div id="nc">
        <section :class="nc"></section>
        <button @click="a = !a">a: {{ a }}</button>
        <button @click="b = !b">b: {{ b }}</button>
    </div>


    <!--<script type="text/x-template" id="b-toggle"></script>-->

	<script>

        vue_app(function(_log){
            _log('!2');
            var _obj, _self;
            return {
                data: function(){
                    _log('data', { attrs: this.$attrs });
                    return {
                        a: true,
                        b: false,
                    }
                },
                computed: {
                    nc: function(){
                        return {
                            '-a': this.a,
                            '-b': this.b,
                            '-c': true,
                        }
                    }
                },
                watch: {
                    a: function(val){

                    }
                },

                mounted: function() {

                }
            }

        }, function(_log){

            _log('!3');
            App = _App.mount('#nc');

            _log('!M', { App, _App });
        })


    </script>


<?
$body = ob_get_clean();

print rb_tpl('page', 'page', array(
	'pageTitle' => 'vue: nc - classNames',
	'body' => $body,
	'webkit' => array(
		'vue-env'
	),
));