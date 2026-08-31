<?
//include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';


?>

<script type="text/javascript" src="/js/vue/3.2.20/vue.global.js"></script>
<script type="text/javascript" src="/js/vue-router/4.0.12/vue-router.global.js"></script>
<script type="text/javascript" src="/js/vue-storage/3.1.0/vuejs-storage.umd.min.js"></script>
<script type="text/javascript" src="/js/lodash/4.17.21/lodash.min.js"></script>
<script type="text/javascript" src="/js/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="/js/emittery/0.6.0/index.standalone.js"></script><script>var emittery = new Emittery(); </script>
<script type="text/javascript" src="/js/w-pending_fn/pending_fn.js"></script>

<script type="text/javascript" src="/r/rb/vue/env.js.php"></script>

<div class="K">
	<div>html</div>
	<cmpt>cmpt</cmpt>
	<modal-button>modal-button</modal-button>
</div>

<script>

    const app = Vue.createApp({})


    var _cmpt;
	var Cmpt;


    Cmpt = app.component(
        'modal-button',
        _cmpt = _vue('cmpt', function(_log, _cmd){
            return {
                _vue: {},
                data: function(){ return {
                    modalOpen: false
                } },
                mounted: function() { _log('mounted') },
                template: `
					<button type="button" @click="modalOpen = true">
					  Открыть полноэкранное модальное окно!
					</button>

					<div v-if="modalOpen" class="modal">
					  <div>
					    Информация в модальном окне!
					    <button type="button" @click="modalOpen = false">
					      Закрыть
					    </button>
					  </div>
					</div>
  				`,
            }
        })
    );

    console.log({ Cmpt, _cmpt })

    var body = $('BODY')[0];
    //app.mount('body');
    app.mount(body);
</script>