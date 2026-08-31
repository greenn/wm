<?
$vueName = basename(__FILE__, '.vue.js.inc');
$Self = _kot::self();
$n = $Self::nc();




?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
                'formatDate',
            ],
        },

        props: ['cfg'],
        data(){
            //_log('data');
            return {
                /*cfg: {
                    passes_min: 0,
                    'passes_min-fix': false,
                    from: 0,
                    'from-fix': false,
                    to: 0,
                    'to-fix': false,
                }*/
            }
        },

        methods: {

        },

        mounted(){
            //_log('mounted')
        },
    }
})