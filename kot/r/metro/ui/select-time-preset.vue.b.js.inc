<?
$Self = _kot::self()
?>
_vue('select-time-preset', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [],
        },

        props: [
            'label',
            'value', 'checkbox',
            'from', 'to',
            'type', 'dates'
        ],
        emits: [
            'onReady', 'onBusy',
            'update:value', 'update:checkbox',
            'update:from', 'update:to',
        ],

        data: function(){
            return {
                busy: false,
                options: [],
                optionsInfo: {},
                dateType: this.$props.type === 'time' ? 'datetime-local' : 'date'
            }
        },




        methods: {

            setRelValues: function(){
                var to = _getCurrentDateTime(true, this.dateType);

                var valueInfo = this.optionsInfo[this.value];
                var from = _getCurrentDateTime(valueInfo, this.dateType, true);

                //_log('setRelValues', { from, to, valueInfo, value: this.value, optionsInfo: _cc(this.optionsInfo), options: _cc(this.options) });
                this.$emit('update:to', to);
                this.$emit('update:from', from);
            },

            initValue: function(){
                var self = this;

                self.setRelValues();
            },

            loadData: function(next){
                var self = this;

                Api.assignArray({
                    //dbg: true,
                    api: this.dateType === 'date' ? 'ui/select-date-preset' : 'ui/select-time-preset',
                    responseProp: ['data', 'options'],
                    res: [self, 'options'],
                    instantly: true,
                    busy: function(state){
                        self.busy = state;
                        self.$emit('onBusy', state);
                    },
                    cbRes: function(responseData, response){
                        self.optionsInfo = response.data.info;
                        self.$emit('onReady', self.options);
                        next && next()
                    },
                });
            }

        },

        watch: {
            value: function() {
                this.setRelValues();
            }
        },

        mounted(){
            //this._log('mounted')
            this.loadData(this.initValue);
            //this._log('mounted', { props: _cc(this.$props) })
        },
    }
})