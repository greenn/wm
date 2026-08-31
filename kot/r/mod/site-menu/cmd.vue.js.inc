<?
$Self = _kmod::self();
//$n = $Self::nc();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>

_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            //multiInstances: true,
            provide: [
                //{ 'linkRel': '<?=kot('hp', 'namedUrl', 'site-menu')?>' }
            ],

        },

        data(){
            //_log('data');
            return {}
        },

        methods: {},

        mounted(){
            //_log('mounted')
        },
    }
})