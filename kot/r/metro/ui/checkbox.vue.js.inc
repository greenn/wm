<?
$Self = _kot::self()
?>
_vue('ui-checkbox', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
                'ui/field/validate',
            ],
        },

        props: [
            'label',
            'value',
            'disabled', 'req',
            'msgWarn',
            //'relValid',  @provide ui/field/validate,
        ],
        emits: [
            'update:value',
        ],


        data(){
            return {
                id: _.uniqueId('f_'),

                cssClass: {},

                hover: false,
                focus: false,

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

            setFocus: function(){
                this.$refs.checkbox.focus()
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
            notValid: function(){//01
                return this.valid === false;
            },
        },


        mounted(){
            //this._log('mounted')
            //this.warn = true; //dbg
        },
    }
})