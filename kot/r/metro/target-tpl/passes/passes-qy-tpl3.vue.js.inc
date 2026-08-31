<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'))
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
                //'formatDate',
            ],
        },

        props: ['cfg'],
        data(){
            //_log('data');
            return {
                /*cfg: @props {
                    'passes_min': 0,
                    'passes_min-fix': false,
                    'interval': '',
                    'from': 0,
                        'from-fix': false,
                    'to': 0,
                        'to-fix': false,
                }*/
            }
        },

        methods: {},
        
        mounted(){
            //_log('mounted', { data: _cc(this.cfg) })
        },
    }
})