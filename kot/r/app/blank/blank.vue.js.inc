<?
$Self = _kot::self();
//$n = $Self::nc();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            //multiInstances: true,
            provide: [],
        },

        data(){
            //_log('data');
            return {
                content: '- <?=$Self::cfg('className')."/$vueName"?> -'
            }
        },

        methods: {},

        mounted(){
            _log('mounted')
        },
    }
})