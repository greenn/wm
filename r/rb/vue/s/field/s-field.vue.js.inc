_vue('s-field', function(_log){

    return {
        inheritAttrs: false,

        data: function(){
            var set = _.extend({}, this.$attrs, this.$attrs.set);

            if (!1) _log('data0', {
                props: _clearObject(this.$props),
                attrs: _clearObject(this.$attrs),
            });

            return {
                msg: '',
                id: _.uniqueId('_'),
                cssClass: {},
                saved_value: set.value,
                value: set.value,
                name: set.name,
                label: set.label || set.name,
                attrs: _pickAttrs(this.$attrs, ['r']),
                hover: false,
                focus: false,
                req: false,
                on_validate: false,
                //show_msg: false,
            }
        },

        methods: {
            validate: function(){
                this.on_validate = true;

                var valid = true;
                if (this.req) {
                    if (!this.value) {
                        valid = false;
                    }
                }
                return valid;
            },

            update: function(){
                this.saved_value = this.value;
            },
        },
        watch: {
            value: function(newValue, oldValue){
                //_log('w:value', { newValue, oldValue, 'thisValue': this.value })
                this.$emit('onChange', newValue)
            },
            focus: function(state){
                this.cssClass['-focus'] = state;
            },
            hover: function(state){
                this.cssClass['-hover'] = state;
            },
        },
        computed: {
            show_msg: function(){
                return this.on_validate && this.msg;
            }
        },
        mounted: function() {
            //var $node = $(this.$el)
        }
    }
})