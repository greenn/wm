<?
$Self = _kot::self()
?>
_vue('select-station', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
                'ui/field/validate',
            ],
        },

        props: [
            'label',
            'value', 'checkbox',
            //'multiple'
            //value: [Array, String], // Принимаем массив или строку в props
        ],
        emits: [
            'update:value', 'update:checkbox',
            'onReady', 'onBusy'
        ],

        data: function(){
            return {
                busy: false,
                options: [],
                //multiple: false,
                //station: '',
                stations: {},

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
                return this.value.length
            },



            getStationTitle(id){
                var station = this.stations && this.stations[id];
                //_log('getStationTitle', { id, station, stations: _cc(this.stations) })
                return station ? station.text : '-';
            },

            addValue: function(id){
                var value = this.value || [];
                value.push(id);
                this.$emit('update:value', value)
            },
            removeValue: function(id){
                var value = this.value;
                _.pull(value, id);
                this.$emit('update:value', value)
            },

            loadData: function(){
                var self = this;

                _r('ui', 'selectStation_getOptions', {
                    busy: function(state){
                        self.busy = state;
                        self.$emit('onBusy', state);
                    },
                    next: function(options, stations){
                        //_log('loadData/res', { arg1 })
                        self.options = options;
                        self.stations = stations;
                        self.verifyOptions()
                        self.$emit('onReady');
                    }
                })
            },

            verifyOptions(){
                var self = this;
                _.each(this.options, function(opt){
                    opt.disabled = _.includes(self.value, opt.value);
                    //_log('verifyOptions/match', { match: opt.disabled, opt, optValue: opt.value, values: _cc(self.value) });
                })
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
                    res.push({ id, title: self.getStationTitle(id) })
                }, [])
                return _.sortBy(titles, 'title');
            },

            disabler(){
                return _.size(this.value) >= 3;
            }
        },


        mounted(){
            //this._log('mounted')
            this.loadData();

            //this._log('mounted', { props: _cc(this.$props) })

            //this._log('mounted', { data: _cc(this.$data), valid: this.valid })
        },
    }
})