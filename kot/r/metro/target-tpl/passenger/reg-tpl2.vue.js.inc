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
                /*cfg: @props
                    flag: false,

                    'interval': '',
                */

                //@provide target-tpl2
                    //coverage: false,
                    //busyCoverage: false,
            }
        },

        methods: {
            //calcCoverage() @provide target-tpl2
        },

        watch: {
            //cfg() @provide target-tpl2 //dbg
        },

        //mounted @provide target-tpl2

    }
})