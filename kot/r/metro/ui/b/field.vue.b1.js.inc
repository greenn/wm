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
            'msgWarn',
        ],
        emits: [
            'update:value', 'update:checkbox'
        ],


        data(){
            //var set = _.extend({}, this.$attrs, this.$props.set);

            //_log('data');
            var value = this.$props._value || this.$props.def;
            return {
                id: _.uniqueId('f_'),
                cssClass: {},

                hover: false,
                focus: false,
                req: false,

                saved_value: value,
                msg: '',


                valid: null,
                on_validate: false, //01
                validateOnChange: false,
                stopValidateOnSuccess: false,

                warnInput: false,
                warnTooltip: false,

                msgWarnDef: 'Необходимо заполнить это поле',
            }
        },

        methods: {

            isValid: function(val){ //дефолтный метод, может быть перезаписан
                return !!val;
            },

            validate: function(set, setFocus){
                var self = this;
                //_set.fetch(this, ['isValid', 'validateOnChange', 'stopValidateOnSuccess'])
                if (set) _.each(['isValid', 'validateOnChange', 'stopValidateOnSuccess'], function(prop){
                    if (set.hasOwnProperty(prop)) self[prop] = set[prop]
                })

                this.on_validate = true; //01
                this.valid = this.isValid(this.value);
                if (!this.valid && setFocus) this.setFocus();

                return this.valid;
            },

            showWarn: function(state){
                this.warnInput = state; //показываем warn-input
                this.warnTooltip = state; //показываем warn-tooltip
            },

            update: function(){ //507
                this.saved_value = this.value;
            },

            setFocus: function(){
                this.$refs.input.focus()
            }
        },

        watch: {
            value: function(val){
                _log('w:value', { val, 'validate?': this.validateOnChange });
                if (this.validateOnChange) {
                    this.validate();
                }
            },

            valid: function(val){
                _log('w:valid', { val });
                this.showWarn(!val);
                if (val && this.stopValidateOnSuccess) {
                    this.on_validate = false; //01
                    this.validateOnChange = false;
                }
            },


            focus: function(state){
                this.cssClass['-focus'] = state;
            },
            hover: function(state){
                this.cssClass['-hover'] = state;
            },
            warnInput: function(state){
                //this.log('w:warn');
                this.cssClass['-warn'] = state;
            },
        },

        computed: {
            notValid: function(){//01
                return this.valid === false;
            },

            show_msg: function(){//01
                return this.on_validate && this.msg;
            }
        },


        mounted(){
            //this._log('mounted')
            //this.warn = true; //dbg

        },
    }
})