<?
$Self = _kot::self()
?>
_vue('<?=basename(__FILE__, '.vue.js.inc')?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [],
        },

        //inheritAttrs: false,
        props: ['label', 'value'],

        data(){
            //var set = _.extend({}, this.$attrs, this.$props.set);

            //_log('data');
            return {
                id: _.uniqueId('f'),
                cssClass: {},
                hover: false,
                mouse: false,
            }
        },

        methods: {},

        watch: {
            hover: function(state){
                this.cssClass['-hover'] = state;
            },
            mouse: function(state){
                this.cssClass['-click'] = state;
            },
        },

        mounted(){
            //this._log('mounted')
        },
    }
})