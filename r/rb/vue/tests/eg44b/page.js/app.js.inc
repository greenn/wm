<? $nP; $js ?>

    let Page;
    const _Page = Vue.createApp({
        data(){
            return {
                responseData: false,
                routeCmptName: 'v-view3'
            }
        },
        methods: {
            sendApi: function(){
                console.log('sendApi');
            }
        }
    })





    $(function(){
	    <? include $js['router'] ?>


        _Page.use(router)

        Page = _Page.mount('.<?=$nP?>');
        console.log('Page', {
            _Page: _Page,
            Page: Page,
            _Api: _Api,
        })
    })