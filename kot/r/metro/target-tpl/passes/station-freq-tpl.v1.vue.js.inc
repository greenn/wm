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
                //'getCurrentDateTime'

                'target-tpl/w:wait',
                    //'target-tpl/onReady',
                    //'target-tpl/w:cfg',

                'target-tpl/fetchInitData',
                    //'target-tpl/fetchData',

                ///'target-tpl/validate',
                { 'target-tpl/validate': { itemsProp: 'validateItems' } }
            ],
        },

        emits: [
            'onRemove',
            'onChange',
        ],

        props: [
            'on_mount',
            'initData',
        ],

        data(){
            //_log('data', { 'props.setData': _clone(this.$props.setData), setData: _clone(this.setData)});

            var cfg = {
                id: 0,

                passes_min: 0,
                'passes_min-fix': false,

                interval: '',

                station: '',
                'station-fix': true,
                //~ from: ''
                //~ to: ''

                //from: _getCurrentDateTime({ week: -1 }, true),
                ///'from_preset': '',
                //'from-fix': true,

                //to: _getCurrentDateTime(true, true),
                ///'to_preset': '',
                //'to-fix': true,
            };

            return {
                //cfg: _.extend(cfg, this.$props.setData),
                cfg: cfg,

                //validateItems: [],
                validateItems: {},

                wait: {
                    interval: false,
                    station: false,
                },
                ready: false,

                dbg_counter: 1,
            }
        },

        methods: {
            //onReady @provide 'target-tpl/onReady'
            //fetchData @provide 'target-tpl/fetchData'
            //fetchInitData @provide 'target-tpl/fetchInitData'

            //validate @provide 'target-tpl/validate'
                    //kot/r/target-tpl/provide/validate.js.inc
                        //kot/r/ui/provide/field-validate.js.inc

            addValidate(ref, name){
                if (!this.validateItems[name]) {
                    //this._log('addValidate', { name, ref, name1: this.name1 })
                    var item = { ref, name };
                    item.isValid = function(value){
                        //this ~ ui-field / ui-select
                        _log('validate', [name, this.name1], { value: this.value, name: this.name1, fix: this.checkbox })
                        return false;
                    }
                    this.validateItems[name] = item;
                }
            }
        },

        watch: {
            //wait @provide 'target-tpl/w:wait'
            //cfg @provide 'target-tpl/w:cfg'
        },

        mounted(){
            //_log('mounted', { initData: this.initData, _initData: _cc(this.initData) })
            //_log('mounted', { validateItems: this.validateItems })
        },
    }
})