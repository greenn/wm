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

                numFrom: 0,
                numTo: 0,
            };

            return {
                cfg: cfg,
                validateItems: {},
                wait: {},
                ready: true,
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
        },

        mounted(){
            //_log('mounted', { initData: this.initData, _initData: _cc(this.initData) })
        },
    }
})