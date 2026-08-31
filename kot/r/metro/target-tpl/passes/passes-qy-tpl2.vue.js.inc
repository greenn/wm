<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'))
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
                'target-tpl2',
            ],
        },

        props: ['cfg'],
        data(){
            //_log('data');
            return {
                /*cfg: @props {
                    'qy': 0,
                    'qy-fix': false,
                    'interval': '',
                    //'from': '',
                    //'to': '',
                }*/
            }
        },

        methods: {},

        //mounted @provide target-tpl2

        mounted(){
            //this.log('mounted|decl', { data: _cc(this.cfg) })
        },
    }
})