<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
ob_start();
?>
	<style>
		BODY { background-color: lightgoldenrodyellow }
        BUTTON { font: 12px monospace; margin-left: 6px; }
        BUTTON[raw] { color: darkgreen }
        BUTTON[hide] { color: darkred }
        BUTTON[unhide] { color: orangered }
	</style>

    <script type="text/x-template" id="b-toggle">
        <button @click="status = !status">
            <template v-if="status">
                <span> ˅ </span>
                <slot name="opened">[is open] click to close</slot>
            </template>
            <template v-else>
                <span> > </span>
                <slot name="closed">[is closed] click to open</slot>
            </template>
        </button>
    </script>

	<script>

        _vue('b-toggle', function(_log){
            return {
                data: function(){
                    _log('data', { attrs: this.$attrs });
                    return {
                        status: this.$attrs.state
                    }
                },
                watch: {
                    status: function(isOpen){
                        if (isOpen) {
                            this.$emit('open')
                        } else {
                            this.$emit('close')
                        }
                    }
                },

                mounted: function() {}
            }
        })

        vue_app(function(_log){
            var _obj, _self;
            return {
                _vue: {
                    directives: ['visible']
                },
                data: function(){
                    return {
                        sectionOn: false
                    }
                },
                methods: {
                    open: function(){
                        _log('Открывается');
                    },
                    close: function(){
                        _log('Закрывается');
                    },
                },
                mounted: function(){}
            }

        }, function(_log){


            App = _App.mount('#eg');

        })


    </script>

    <style type="text/css">
        .-off { display: none }
    </style>

    <section id="eg">

        <b-toggle @open="sectionOn = true" @close="sectionOn = false" :state="sectionOn"></b-toggle>
        <section :class="{'-off': !sectionOn }">
            SECTION SECTION
        </section>

        <hr />

        <b-toggle @open="$data.val1 = true" @close="$data.val1 = false"></b-toggle>
        <div v-show="$data.val1">VAL-1</div>
        <div v-show="$data.val1">VAL-1 by directive "show"</div>
        <div v-visible="$data.val1">VAL-1 by custom directive "visible"</div>

        <hr />

        <b-toggle @open="open" @close="close">
            <template #closed>Закрыто / Открыть</template>
            <template #opened>Открыто / Закрыть</template>
        </b-toggle>

    </section>
<?
$body = ob_get_clean();

print rb_tpl('page', 'page', array(
	'pageTitle' => 'Vue-Env',
	'body' => $body,
	'webkit' => array(
		'vue-env'
	),
));