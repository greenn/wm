<?
$Self = _kot::self();
$n = $Self::nc();
?>

_vue('<?=basename(__FILE__, '.vue.js.inc')?>', function(_log, _cmd){

    return {
        _vue: {
            provide: [
                //'regField', 'regButton',
                'link', 'linkBack',
                //'applyRealParentMethod', 'getRealParent',
            ],
        },

        data(){
            //_log('data');
            return {
                content: '- <?=$Self::cfg('className')?> -'
            }
        },

        methods: {},

        mounted(){
            //_log('mounted')
        },
    }
})