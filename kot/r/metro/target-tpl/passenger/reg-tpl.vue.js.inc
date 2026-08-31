<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'))
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
                { 'target-tpl': {
                    addValidate: {
                        numFrom: true
                    }
                } }
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

                flag: false,

                interval: '',
                //from: '',
                //to: '',
            };

            return {
                cfg: cfg,
                validateItems: {},
                wait: {
                    interval: false,
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

        },

        watch: {
        //@provide target-tpl
            //wait
            //cfg

            'cfg.flag': function(val){
                //_log('w:cfg.flag', { val })
                //if (val) this.intervalDisabled
            }
        },

        mounted(){
            //_log('mounted', { validateItems: _cc(this.validateItems), refs: _cc(this.$refs) })
        },
    }
})