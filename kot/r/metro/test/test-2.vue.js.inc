<?
$vueName = basename(__FILE__, '.vue.js.inc');
$Self = _kot::self();
$n = $Self::nc();
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            provide: [
                //'link', 'linkBack',
            ],
        },

        data(){
            //_log('data');
            return {
                showTooltip2: false
            }
        },

        methods: {

        },

        mounted(){
            //_log('mounted')
        },
    }
})