<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>
_vue('<?=$vueName?>', function(_log, _cmd){


    return {
        //inheritAttrs: false,

        props: [
            'headline',
            'modal',
            'cmd',
            'content',
        ],

        _vue: {
            multiInstances: true,
            provide: [],
        },

        data(){
            //_log('data0', { attrs: this.$attrs });

            //var fxr = this.$attrs.fxr;
            //if (fxr) delete this.$attrs.fxr;
            //_log('data', { fxr });

            return {
                //_index: _cmd.curIndex(),
                //fxr: fxr
            }
        },

        computed: {
            hasContent: function(){
                return this.content || this.$slots.default;
            },
            hasHeadline: function(){
                return (this.$slots.modal || this.modal)
                    || (this.$slots.headline || this.headline)
                    || (this.$slots.cmd || this.cmd);
            }
        },

        mounted(){
            //this.log('mounted', { data: _cc(this.$data) })
        },
    }
})