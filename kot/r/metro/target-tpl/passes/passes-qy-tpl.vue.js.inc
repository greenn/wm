<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'))
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
                //'target-tpl/addValidate_passesMin',
                { 'target-tpl': {
                    addValidate: {
                        itemsProp: 'validateItems',
                        passes_min: true
                    }
                } }
            ],
        },

        emits: ['onChange', 'onRemove'],
        props: ['initData', 'trgName'],

        data(){
            //_log('data');
            return {
                cfg: {
                    id: 0,
                    name: this.$props.trgName,
                    qy: 0,
                    'qy-fix': false,
                    interval: '',
                    //from: '',
                    //to: '',
                },

                validateItems: {},
                wait: {
                    interval: false,
                },
                ready: false,
            }
        },



        methods: {
        //@provide target-tpl  kot/r/target-tpl/provide/target-tpl.js.inc
            //onReady
            //fetchData
            //fetchInitData

            //validate
            //addValidate

            <? if (0) { ?>
                addValidate(ref, name){
                    var ctx = {}
                    //this.addValidate_passesMin
                    if (name === 'passes_min') {
                        ctx.isValid = function(value){
                            //this ~ ui-field / ui-select
                            //_log('validate/passes_min', [name, this.name1], { value: this.value, name: this.name1, fix: this.checkbox, cond: this.value > 0 })
                            this.msgWarnCustom = '';
                            if (this.checkbox) {
                                if (this.value <= 0) {
                                    this.msgWarnCustom = 'Фиксированное поле не может быть 0'
                                    return false;
                                }
                            }
                            return true;
                        }
                    }

                    this._addValidate(ref, name, ctx);
                }
	        <? } ?>

        },

        watch: {
        //@provide target-tpl
            //wait
            //cfg
        },

        mounted(){
            //  _log('mounted', { validateItems: this.validateItems })
        },
    }
})