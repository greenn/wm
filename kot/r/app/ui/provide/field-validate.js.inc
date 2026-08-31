_vue.provider['ui/field/__validate'] = {
    props: ['relValid'],

    data: function(){
        //_log('fielf-valdiate/data', { } );

        return {
            valid: null,
            on_validate: false, //01 ak validateOnChange
            validateOnChange: false,
            stopValidateOnSuccess: false,

            warnInput: false,
            warnTooltip: false,

            msgWarnDef: 'Необходимо заполнить это поле',
            msgWarnCustom: 'Необходимо заполнить это поле',
        }
    },
    methods: {
        //дефолтный метод, может быть перезаписан
        isValid(val){
            var reqOff = this.req === false;
            var isDisabled = this.disabled;
            var res = (reqOff || isDisabled) ? true : !!val;
            //this.log('isValid', { val, value: this.value, req: this.req, res })
            return res;
        },

        validate(set, setFocus){
            var _set = makeSet(set);
            _set.fetch(this, ['isValid', 'validateOnChange', 'stopValidateOnSuccess', 'msgWarn', 'msgWarnDef'])

            this.on_validate = true; //01

            var valid = this.valid = this.isValid(this.value);

            if(!1) this.log('field-validate', { res: this.valid, setFocus, value: this.value, name: this.name1, isValid: this.isValid,
                set: _clone(set), validateOnChange: this.validateOnChange, stopValidateOnSuccess: this.stopValidateOnSuccess,
            })
            if (!this.valid && setFocus && this.setFocus) this.setFocus();

            //_set.next(this.valid);

            this.setValid(valid)

            return this.valid;
        },

        setValid(value){
            this.showWarn(!value);
            if (value && this.stopValidateOnSuccess) {
                this.on_validate = false; //01
                this.validateOnChange = false;
            }
        },

        showWarn(state){
            this.warnInput = state; //показываем warn-input
            this.warnTooltip = state; //показываем warn-tooltip
        },


    },

    watch: {
        value(val){
            //this.log('w|provide:value', { val, 'validate?': this.validateOnChange });
            if (this.validateOnChange) {
                this.validate();
            }
        },

        relValid(val){
            //this.log('w:relValid', { relValid: val, valid: this.valid })
            this.setValid(val);
        }
    },

    computed: {
        msgTooltip(){
            //this.log('msgTooltip', { msgWarn: this.msgWarn, msgWarnDef: this.msgWarnDef, msgWarnCustom: this.msgWarnCustom })
            return this.msgWarnCustom || this.msgWarn || this.msgWarnDef;
        }
    }
};