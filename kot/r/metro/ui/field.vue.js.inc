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
                'ui/field/validate',
            ],
        },

        //inheritAttrs: false,
        //props: ['set'],
        props: [
            'label',
            'value', 'checkbox', //'_value',
            'type', 'def', 'disabled', 'req',
            'msgWarn',
            'note',
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
                idCheckbox: _.uniqueId('fc_'),

                cssClass: {},

                hover: false,
                focus: false,

                saved_value: value,
                msg: '',

                //valid: @provide ui/field/validate,
                //on_validate: @provide ui/field/validate
                //validateOnChange: @provide ui/field/validate
                //stopValidateOnSuccess: @provide ui/field/validate

                //warnInput: @provide ui/field/validate
                //warnTooltip: @provide ui/field/validate

                //msgWarnDef: @provide ui/field/validate
            }
        },

        methods: {

            //isValid: @provide ui/field/validate
            //validate: @provide ui/field/validate
            //showWarn: @provide ui/field/validate

            update: function(){ //507
                this.saved_value = this.value;
            },

            setFocus: function(){
                this.$refs.input.focus()
            }
        },

        watch: {
            //value: @provide ui/field/validate
            //?relValid: @provide ui/field/validate

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
            checkboxTitle(){
                return !this.checkbox
                    ? '☑ Зафиксировать данное значение в шаблоне'
                    : '☐ Сделать поле доступным для редактирования'
            },
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