<?
$Self = _kot::self()
?>
_vue('ui-select', function(_log, _cmd){

    function isOneLevelArray(arr) {
        return _.every(arr, function(item) {
            return !_.isObjectLike(item);
        });
    }

    return {
        _vue: {
            multiInstances: true,
            provide: [
                //'regField', 'regButton',
                //'link', 'linkBack',
                //'applyRealParentMethod', 'getRealParent',
                'ui/field/validate',
            ],
        },

        inheritAttrs: false,
        //props: ['set'],
        /*props: {
            modelSelected: String,
            optionsData: Array
        },*/

        props: [
            'options', 'label',
            'busy', 'hideBusy',
            'multiple', 'disabled',
            'value', 'checkbox',
            'clickUpdate',
            'msgWarn',
            'relValid', //@provide ui/field/validate
        ],
        emits: [
            'update:value', 'update:checkbox',
            'onFocus', 'onBlur'
        ],

        data(){
            if (0) this._log('data0', {
                props: _clearObject(this.$props),
                attrs: _clearObject(this.$attrs),
            });

            return {
                id: _.uniqueId('s_'),

                msg: '', //01
                cssClass: {},

                hover: false,
                focus: false,

                on_validate: false,

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
                this.$refs.select.focus()
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
            disabled: function(state){
                this.cssClass['-disabled'] = state;
            },

            //checkbox: function(val){ _log('w:checkbox', { checkbox: val })},

            warnInput: function(state){
                //this.log('w:warnInput', { setClass: state });
                this.cssClass['-warn'] = state;
            },
        },

        computed: {
            show_msg: function(){//01
                return this.on_validate && this.msg;
            },

            optionsData: function(){

                var data = this.options;
                var list = data;

                //_log('c:optionsData', { data, isOneLevelArray: isOneLevelArray(data) })
                if (isOneLevelArray(data)) {
                    list = _.reduce(data, function(res, text, index){
                        var item = { text: text, value: text }
                        res.push(item);
                        return res;
                    }, [])
                }
                //_log('c:optionsData', { data, list });
                return list;
            }

        },

        mounted(){
            //this._log('mounted:value', { value: this.value });
            //this._log('mounted', { props: _cc(this.$props) })
            //this._log('mounted', { props: _cc(this.$props), relValid: this.relValid })
        },
    }
})