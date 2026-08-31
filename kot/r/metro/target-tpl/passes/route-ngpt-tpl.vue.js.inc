<?
$Self = _kot::self();
$_ctx = $Self::tempCtx(array(
	'id' => basename(__FILE__, '.vue.js.inc')
));
$vueName = $_ctx['id'];

//$Self = _kot::self();
//$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'))
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
                { 'target-tpl': {
                    'validate': { itemsProp: 'validateItems' },
                    /*'_validate': { itemsProp: 'validateItems' }
                    '_m:validate': { itemsProp: 'validateItems' }
                    'm:validate': { itemsProp: 'validateItems' }*/

                    addValidate: {
                        itemsProp: 'validateItems',
                        passes_min: true
                    },

                } }
            ],
        },

        emits: [
            'onRemove',
            'onChange',
        ],

        props: [
            ///'on_mount',
            'initData',
            'trgName'
        ],

        data(){
            //_log('data', { 'props.setData': _clone(this.$props.setData), setData: _clone(this.setData)});

            var cfg = {
                id: 0,
                name: this.$props.trgName,
                list: '',

                interval: '',
                //from: '',
                //to: '',
            };

            return {
                //cfg: _.extend(cfg, this.$props.setData),
                cfg: cfg,

                //coverage: false, @provide target-tpl
                //busyCoverage: false, @provide target-tpl

                //validateItems: [],
                validateItems: {},

                wait: {
                    interval: false,
                    station: false,
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
        },

        mounted(){
            //_log('mounted', { initData: this.initData, _initData: _cc(this.initData) })

        },
    }
})