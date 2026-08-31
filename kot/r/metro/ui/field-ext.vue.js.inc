<?
$Self = _kot::self()
?>
_vue('ui-field', function(_log, _cmd){


    return {
        _vue: {
            multiInstances: true,
            provide: [
                //'regField', 'regButton',
                'link', 'linkBack',
                //'applyRealParentMethod', 'getRealParent',
            ],
        },

        //inheritAttrs: false,
        //props: ['set'],
        props: [
            'name', 'label', '_value', 'type', 'def', 'disabled',
            'value', 'checkbox',
        ],
        emits: [
            'update:value', 'update:checkbox'
        ],


        data(){
            //var set = _.extend({}, this.$attrs, this.$props.set);

            //_log('data');
            var value = this.$props._value || this.$props.def;
            return {
                msg: '',

                id: _.uniqueId('f_'),
                cssClass: {},

                saved_value: value,
                ///value: value,
                //name: this.$props.name,
                //label: this.$props.label,
                //attrs: _pickAttrs(this.$attrs, ['r']),
                //attrs: this.$attrs,
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

        mounted(){
            //this._log('mounted')
        },
    }
})