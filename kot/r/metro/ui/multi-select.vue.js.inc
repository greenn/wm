<?
$Self = _kot::self()
?>
_vue('multi-select', function(_log, _cmd){

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
            //value: [Array, String], // Принимаем массив или строку в props
            'checkbox',
            'options', 'info', 'busy'
        ],
        emits: [
            'update:value', 'update:checkbox',
            'update:options',
            'onReady', 'onBusy'
        ],

        data: function(){
            return {
                defOpt0: '',
                //@provide ui/field/validate,
                    //valid:
                    //on_validate:
                    //validateOnChange:
                    //stopValidateOnSuccess:

                    //warnInput:
                    //warnTooltip:

                    //msgWarnDef:
            }
        },


        methods: {

            //isValid: @provide ui/field/validate
            isValid: function(){
                return this.value && this.value.length
            },



            getItemTitle(id){
                var station = this.info && this.info[id];
                //_log('getItemTitle', { id, info: _cc(this.info) })
                return station ? station.text : '-';
            },

            addValue: function(id){
                //var value = _.uniq(_.compact(this.value || []));
                var value = this.value ? _.castArray(this.value) : [];
                value.push(id);
                this.$emit('update:value', value)
            },
            removeValue: function(id){
                var value = this.value;
                _log('removeValue', { value: this.value, id })
                _.pull(value, id);
                this.$emit('update:value', value)
            },

            verifyOptions(){
                var self = this;
                if (!this.defOpt0) {
                    if (this.options) {
                        this.defOpt0 = this.options[0].text;
                    }
                }
                var q = _.size(self.value);
                _.each(this.options, function(opt, index){
                    //_log('index', { index, q, defOpt0: self.defOpt0, list: _cc(self.options) });
                    if (!index) {
                        opt.text = q ? `Выбрано: ${q}` : (self.defOpt0 || ' - выбор -');
                    }
                    opt.disabled = _.includes(self.value, String(opt.value));
                    //_log('verifyOptions/match', { match: opt.disabled, opt, optValue: opt.value, values: _cc(self.value) });
                })
                //_log('verifyOptions', { _value: _cc(self.value), _options: _cc(this.options) })
                this.$emit('update:options', this.options)
            },

            //_validate: @provide ui/field/validate
            //showWarn: @provide ui/field/validate
            validate: function(set, setFocus){
                //_log('validate', { args: _.toArray(arguments) });
                //this._validate.apply(this, arguments)
                return this._validate(set, setFocus)
            },

            setFocus: function(){
                this.$refs.select.setFocus()
            }
        },

        watch: {
            //value: @provide ui/field/validate
            //?relValid: @provide ui/field/validate

            value: {
                deep: true,
                handler: function(val){
                    //_log('w|decl:value', { name: this.name1, val: _cc(val) })
                    this.verifyOptions()
                }
            },


        },

        computed: {
            selection(){
                var self = this;
                var titles = _.transform(this.value, function(res, id){
                    res.push({ id, title: self.getItemTitle(id) })
                }, [])
                return _.sortBy(titles, 'title');
            },

            /*disabler(){
                return _.size(this.value) >= 3;
            }*/
        },


        mounted(){
            //_log('mounted')
        },
    }
})