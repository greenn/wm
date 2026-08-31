<?
include_once $_SERVER['DOCUMENT_ROOT'].'/metro-targets/iq.inc';
?>

<script type="text/javascript" src="/js/vue/3.2.20/vue.global.js"></script>
<script type="text/javascript" src="/js/vue-router/4.0.12/vue-router.global.js"></script>
<script type="text/javascript" src="/js/vue-storage/3.1.0/vuejs-storage.umd.min.js"></script>
<script type="text/javascript" src="/js/lodash/4.17.21/lodash.min.js"></script>
<script type="text/javascript" src="/js/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="/js/emittery/0.6.0/index.standalone.js"></script><script>var emittery = new Emittery(); </script>
<script type="text/javascript" src="/js/w-pending_fn/pending_fn.js"></script>
<script type="text/javascript" src="/r/rb/vue/env.js.php?v3"></script>

<link type="text/css" rel="stylesheet" href="/r/rb/lay/flex.css.php" />
<link type="text/css" rel="stylesheet" href="/r/rb/css/aq.css.php" />

<script>
    const Api = WebApi({
        baseUri: '/api/metro',
        delay: 1500
    });

    const Web = WebHelper({
        'page-title': {
            'suffix': 'TEST API',
        }
    });

    VueRoot.vue.init({
        mount: '#app',

        decl: function(_log){
            return {
                data(){
                    return {}
                },
                methods: {
                    delay: function(){
                        _log.time('api-with-delay', Api.delay());

                        Api.request.get('targets/test-delay', { ms: 1600 }, function(response){
                            _log('delay/api:response', { response })
                            _log.timeEnd('api-with-delay');
                        })
                    },

                    create: function(){
                        Api.request.post('targets/create', { fields: {
                            name: 'test-' + _.uniqueId()
                        }}, function(response){
                            _log('create/api:response', { response })
                        }, { emu: true})

                    }
                },

                mounted(){
                    _log('mounted');
                }

            }
        },
    });

</script>

<div id="app">
    <button @click="create">Create</button>
    <button @click="delay">test-delay</button>

</div>