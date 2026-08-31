<?
$Self = _kot::self()
?>
_vue('ui-button', function(_log, _cmd){


    return {
        //inheritAttrs: false,

        emits: ['click', 'hover'],
        props: ['disabled'],

        _vue: {
            multiInstances: true,
            provide: [
                //'regField', 'regButton',
                //'relLink',
                'link', 'linkBack',
                //'applyRealParentMethod', 'getRealParent',
            ],
        },

        data(){
            //_log('data');
            return {
                //disabled: this.$props.disabled,
                //_index: _cmd.curIndex(),

                click: false,
                hover: false,
                //attrs: _pickAttrs(this.$attrs, ['r', 'rst']),
                attrs: this.$attrs,
                cssClass: {},
                //text: this.$attrs.text || 'button',

                busy: false,

                icon: {},
            }
        },

        watch: {
            click: function(state){
                if (this.disabled) return; //01
                this.cssClass['-click'] = state;
            },
            hover: function(state){
                this.cssClass['-hover'] = state;
            },
        },

        methods: {},

        mounted(){
            //this._log('mounted')
        },
    }
})