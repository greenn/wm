<?
$Self = _kot::self()
?>
_vue('select-station', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
                ///'ui/field/validate',
                    //по-хорошему здесь нужен 'target-tpl' /  iq/config/.dev/man target-tpl
            ],
        },

        props: [
            'value', 'label',
            'passes',
            'options', 'relOptions',
            'addButton', 'addButtonDisabled',
            //'mcd'
        ],
        emits: [
            'update:value',
            'update:passes',
            'onAdd',
            'onRemove',
            'onBusy',
            'onReady',
        ],

        data: function(){
            return {
                busy: false,
                selfOptions: [],
                //station: '',

            }
        },


        methods: {
            loadData: function() {//01
                var self = this;
                //_log('loadData/0');
                _r('ui', 'selectStation_getOptions', {
                    busy: function (state) {
                        self.busy = state;
                        self.$emit('onBusy', state);
                    },
                    next: function (options, stations) {
                        //_log('loadData/res', { options, stations })
                        self.selfOptions = options;
                        //self.stationsInfo = stations;

                        self.$emit('onReady');
                    }
                })
            },


            setFocus: function(){
                this.$refs.select.setFocus()
            }
        },


        mounted(){
            if (!this.relOptions) this.loadData();
        },
    }
})