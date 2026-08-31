<?
$Self = _kot::self()
?>
_vue('<?=basename(__FILE__, '.vue.js.inc')?>', function(_log, _cmd){


    return {
        //inheritAttrs: false,

        //emits: ['click'],


        _vue: {
            multiInstances: true,
            provide: [
                //'regField', 'regButton',
                //'link', 'linkBack',
                //'applyRealParentMethod', 'getRealParent',
            ],
        },

        props: ['total', 'busy'],

        data(){
            //_log('data', { $props: _clearObject(this.$props) });
            return {
                numStart: this.$props.total ? 1 : 0,
                numEnd:  this.$props.total || 0,
                perPageStack: [10, 25, 50, 100],
                perPage: 50,
            }
        },

        methods: {},

        watch: {
            total: function(val){
                //_log('w:total', val);
                this.numStart =  val ? 1 : 0,
                this.numEnd = val || 0
            }
        },


        mounted(){
            //this._log('mounted')
        },
    }
})