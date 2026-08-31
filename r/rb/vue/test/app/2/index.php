<?
//include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';


?>
<? include 'js.scripts.inc'?>

<div class="K">
	<div>html ({{ num }})</div>
	<cmpt>cmpt</cmpt>

    <hr />
	<modal1>modal 1</modal1>

    <hr />
	<modal2>modal 2</modal2>
</div>

<script>
    //console.time("instance-2");
    console.time("mounted-1");
    console.time("mounted-2");

    var lookForProps = function(obj, prop, title){
        if (!title) console.time(title = [prop, lookForProps.counter++].join('-'));
        setTimeout(function(){
            if (!obj[prop]) lookForProps(obj, prop, title);
            else console.timeEnd(title);
        }, 1)
    }
    lookForProps.counter = 1;

    const app = Vue.createApp({})


    var _cmpt = _vue('cmpt', function(_log, _cmd){
        _cmd.counter = 1; // для повторяющихся компонентов

        return {
            _vue: {
                provide: ['link']
            },
            data: function(){ return {
                modalOpen: false,
                index: _cmd.curIndex(),
                num: 10,
            } },
            mounted: function() {
                _log('mounted', { this: this,
                    'Cmpt1._instance': Cmpt1._instance,
                    //'Cmpt1._instance.proxy.index': Cmpt1._instance.proxy.index,
                })
                console.timeEnd(['mounted', this.index].join('-'));
            },
            template: `
                <button type="button" @click="modalOpen = true">
                  Открыть полноэкранное модальное окно!
                  {{ index }} / {{ num }}
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
    });


    if(0) {
        const AsyncPopup = defineAsyncComponent({
            loader: () => import('./LoginPopup.vue'),
            loadingComponent: LoadingComponent /* shows while loading */,
            errorComponent: ErrorComponent /* shows if there's an error */,
            delay: 1000 /* delay in ms before showing loading component */,
            timeout: 3000 /* timeout after this many ms */,
        })
    }




    var Cmpt1 = app.component('modal1', _cmpt);
    var Cmpt2 = app.component('modal2', _cmpt);


    lookForProps(Cmpt2, '_instance');


    //Cmpt2._instance.proxy.num = 11;

    //console.log({ Cmpt1: _clone(Cmpt1), Cmpt2, _cmpt });

    //app.mount('body');
    app.mount($('BODY')[0]);
</script>