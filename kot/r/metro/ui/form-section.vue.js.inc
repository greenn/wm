<?
$Self = _kot::self()
?>
_vue('<?=basename(__FILE__, '.vue.js.inc')?>', function(_log, _cmd){


    return {
        //inheritAttrs: false,

        emits: ['click'],

        _vue: {
            multiInstances: true,
            provide: [
                //'regField', 'regButton',
                'link', 'linkBack',
                //'applyRealParentMethod', 'getRealParent',
            ],
        },

        data(){
            //_log('data');
            return {
                //_index: _cmd.curIndex(),
            }
        },

        methods: {},

        mounted(){
            //this._log('mounted')
        },
    }
})