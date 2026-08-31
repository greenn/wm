<?
$Self = _kot::self()
?>
_vue('<?=basename(__FILE__, '.vue.js.inc')?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: []
        },

        //inheritAttrs: false,
        props: ['label', 'value', 'busy', 'ncValue'],

        data(){
            //_log('data');
            return {}
        },

        methods: {},

        watch: {},

        mounted(){
            //this._log('mounted')
        },
    }
})