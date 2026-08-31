<?
$Self = _kot::self()
?>
_vue('select-stations', function(_log, _cmd){

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
            'mcd'
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
                options: [],

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
                        passes: item.passes
                    };
                })
                //_log('updateValue', { newValue, prevValue: _cc(this.value) })
                this.$emit('update:value', newValue);
            },

            loadData: function(next) {
                var self = this;

                var api = this.mcd ? 'selectMcd_getOptions' : 'selectStation_getOptions';

                _r('ui', api, {
                    busy: function (state) {
                        self.busy = state;
                        self.$emit('onBusy', state);
                    },
                    next: function (options, stations) {
                        //_log('loadData/res', { options, stations })
                        self.options = options;
                        //self.stationsList = stations;

                        self.$emit('onReady');

                        next && next();
                        //next && setTimeout(next, 0);
                    }
                })
            },

            //isValid: @provide ui/field/validate
            isValid: function(){
                _log('isValid');
                return true;

                return this.value.length
            },

            addItem: function(data){
                //_log('addItem', { data });
                this.stations.push(data || { id: '', passes: 0 });
            },

            removeItem: function(index){
                //_log('removeItem', { index });
                this.stations.splice(index, 1);
                return;

                    //v
                    this.stations[index] = undefined;


                    //v
                    //delete this.stations[index];

                    //v
                    this.stations = this.stations.filter(function(item) {
                        return item !== value;
                    });
            },

            //дизайблит выбранную станции среди других
            verifyOptions(){
                //_log('verifyOptions', { value: _cc(this.value), _options: _cc(this.options) });
                var self = this;
                _.each(this.options, function(opt){
                    if (!opt.value) return;
                    opt.disabled = _.some(self.value, function(station) {
                        return station.id === opt.value;
                    });
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

                    var valid1 = ref.passes.validate(set, setFocus);

                    if (!valid1 && setFocus) setFocus = false; //убираем флаг 'проставить-фокус'

                    var valid2 = ref.station.validate(set, setFocus);

                    res *= valid1 * valid2;

                    //_log('validate', { index, item, valid1, valid2, res})
                })

                return res;
            },

            validate1: function(set){
                _log('validate', { set });
                var valid = true;
                if (this.stations.length === 1) {
                    //_log('validate/1', { 'ref.$refs': this.stations[0].ref.$refs  });
                    valid = this.stations[0].ref.$refs.select.validate({
                        validateOnChange: true,
                        stopValidateOnSuccess: true,
                    });
                }
                return valid;
            },

            setFocus: function(){ _log('setFocus'); },
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
            });

            //this._log('mounted', { props: _cc(this.$props) })
        },
    }
})