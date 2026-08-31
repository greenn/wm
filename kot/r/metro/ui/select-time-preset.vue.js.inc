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
            'type',
            'dates', 'datefields',
            'disabled'
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


            loadData: function(next){
                var self = this;

                _r('ui', 'selectTimePreset_getOptions', this.dateType, {
                    busy: function(state){
                        self.busy = state;
                        self.$emit('onBusy', state);
                    },
                    next: function(options, optionsInfo){
                        self.options = options;
                        self.optionsInfo = optionsInfo;
                        self.$emit('onReady', self.options); //01
                        next && next()
                    }
                })
            },

            validate: function(set, setFocus){

                var res = this.$refs.select.validate(set, setFocus)
                return res;
            }

        },

        watch: {
            value: function() {
                this.setRelValues();
            }
        },

        mounted(){
            //this._log('mounted')
            this.loadData(this.setRelValues);
            //this._log('mounted', { props: _cc(this.$props) })
        },
    }
})