<?
$Self = _kot::self()
?>
_vue('select-ngpt', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
                'ui/field/validate',
            ],
        },

        props: [
            'label',
            'value', //'checkbox',
            'valueWait',
        ],
        emits: [
            'update:value', //'update:checkbox',
            'onReady', 'onBusy'
        ],

        data: function(){
            return {
                stations: [],

                valueReady: !this.$props.valueWait,

                busy: false,

                optionsData: {},
                typeOptions: [],

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

            initData: function(dataList){ //ak fetchData
                var self = this;
                _.each(dataList, function(data, index){
                    self.addItem(data);
                })
                this.valueReady = true;
            },

            updateValue: function(){
                var newValue = _.map(_.filter(this.stations), function(item) {
                    return {
                        id: item.id,
                        type: item.type,
                        passes: item.passes,
                    };
                })
                //_log('updateValue', { newValue, prevValue: _cc(this.value) })
                this.$emit('update:value', newValue);
            },

            loadData: function(next) {
                var self = this;

                var next2 = _.after(2, next);

                _r('ui', 'selectNgpt_getOptions', {
                    busy: function (state) {
                        self.busy = state;
                        self.$emit('onBusy', state);
                    },
                    next: function (options, info) {
                        //_log('loadData/res', { options, info })
                        self.typeOptions = options;
                        //self.typeInfo = info;

                        self.$emit('onReady');

                        next2();
                    }
                })

                _r('ui', 'selectNgptStation_getOptions', {
                    busy: function (state) {
                        self.busy = state;
                        self.$emit('onBusy', state);
                    },
                    next: function (options, info) {
                        //_log('loadData/NgptStation/res', { options, info })
                        self.optionsData = options;
                        //self.typeInfo = info;

                        self.$emit('onReady');

                        next2();
                    }
                })
            },

            //isValid: @provide ui/field/validate

            isValid: function(){ _log('isValid'); return true; }, //q0
            setFocus: function(){ _log('setFocus'); }, //q0

            addItem: function(data){
                //_log('addItem', { data });
                this.stations.push(data || { id: '', passes: 0 });
            },

            removeItem: function(index){
                this.stations.splice(index, 1);
            },

            //дизайблит выбранную станции среди других
            verifyOptions(){
                var self = this;

                if (!1) _log('verifyOptions', {
                    _optionsData: _cc(this.optionsData),
                    _value: _cc(this.value),
                    typeList: _cc(typeList),
                    byType: _cc(byType),
                    size: _.size(this.optionsData),
                    _stations: _cc(this.stations)
                });

                if (!_.size(this.optionsData)) return;

                var byType = _.groupBy(this.value, 'type');
                _.each(byType, function(list, type){
                    //var idList = _.map(list, 'id');
                    //_log('verify', { idList: _cc(idList) })
                    _.each(self.optionsData[type], function(opt){
                        if (!opt.value) return;
                        //opt.disabled = _.includes(idList, opt.value);
                        opt.disabled = _.some(list, function(item) {
                            return item.id === opt.value;
                        });
                    })
                })
            },


            addValidate(ref, item, index){
                //_log('addValidate', { itemRef: item.ref, itemId: item.id, index });
                if (!item.ref) item.ref = ref;
            },

            //_validate: @provide ui/field/validate
            //showWarn: @provide ui/field/validate

            validate: function(set){
                //_log('validate2', { set });

                var self = this;
                var res = true;
                var setFocus = true;
                _.each(this.stations, function(item, index){
                    var ref = item.ref.$refs;

                    var valid1 = ref.num.validate(set, setFocus);

                    if (!valid1 && setFocus) setFocus = false; //убираем флаг 'проставить-фокус'

                    var valid2 = ref.value_type.validate(set, setFocus);

                    if (!valid2 && setFocus) setFocus = false; //убираем флаг 'проставить-фокус'

                    var valid3 = ref.id.validate(set, setFocus);

                    res *= valid1 * valid2 * valid3;

                    //_log('validate', { index, item, valid1, valid2, res})
                })

                return res;
            },
        },

        watch: {
            //value: @provide ui/field/validate
            //?relValid: @provide ui/field/validate

            stations: {
                deep: true,
                handler: function(val){
                    //_log('w:stations', { value: val, _value: _cc(val) });
                    if (this.valueReady) {
                        this.updateValue();
                    }

                    this.verifyOptions();
                }
            },

            value: {
                deep: true,
                handler: function(val){
                    //_log('w:value', { _value: _cc(val), valueReady: this.valueReady });
                    if (!this.valueReady) {
                        this.initData(val);
                    }
                }
            },


        },

        computed: {},


        mounted(){
            var self = this;
            //this.busy = true; return;
            this.loadData(function(){
                //_log('mounted/laodData/', { valueWait: self.valueWait, value: _cc(this.value) })
                if (!self.valueWait) self.addItem();
                self.verifyOptions();
            });

            //this._log('mounted', { props: _cc(this.$props) })
        },
    }
})