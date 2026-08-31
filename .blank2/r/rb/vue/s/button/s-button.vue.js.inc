_vue('s-button', function(_log){
    return {
        inheritAttrs: false,

        data: function(){

            if (!1) _log('data0', {
                props: _clearObject(this.$props),
                attrs: _clearObject(this.$attrs),
                slots: _clearObject(this.$slots),
                //'slots/default:': _clearObject(this.$slots.default()),
                'slots/default': this.$slots.default,
            });

            return {
                click: false,
                hover: false,
                attrs: _pickAttrs(this.$attrs, ['r', 'rst']),
                cssClass: {},
                text: this.$attrs.text || 'submit',

                busy: false,

                icon: {},
            }
        },
        watch: {
            click: function(state){
                this.cssClass['-click'] = state;
            },
            hover: function(state){
                this.cssClass['-hover'] = state;
            },
        },

        methods: {

        },

        mounted: function() {}
    }
})