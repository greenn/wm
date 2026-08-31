<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'))
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
                'target-tpl'
            ],
        },

        emits: [
            'onRemove',
            'onChange',
        ],

        props: [
            'initData',
            'trgName'
        ],

        data(){
            var cfg = {
                id: 0,
                name: this.$props.trgName,

                list: '',
            };

            return {
                cfg: cfg,
                validateItems: {},

                busy: false,
                options: [],
                optionsInfo: {},

                wait: {
                    select: false,
                },
                ready: false,
            }
        },

        methods: {
        //@provide target-tpl
            //onReady
            //fetchData
            //fetchInitData

            //validate
                    //kot/r/target-tpl/provide/target-tpl.js.inc
                    //kot/r/ui/provide/field-validate.js.inc

            //addValidate - добавляет поле(field,select,station) для валидации

            loadOptions(next){
                var self = this;
                _r('ui', 'selectEquipment_getOptions', {
                    busy: [self, 'busy'],
                    next: function(options, optionsInfo){
                        //_log('loadData', { options, optionsInfo })
                        self.options = options;
                        self.optionsInfo = optionsInfo;

                        next && next()
                        self.wait.select = true;
                    }
                })
            }
        },

        watch: {
        //@provide target-tpl
            //wait
            //cfg
        },

        mounted(){
            //_log('mounted', { initData: this.initData, _initData: _cc(this.initData) })
            this.loadOptions();
        },
    }
})