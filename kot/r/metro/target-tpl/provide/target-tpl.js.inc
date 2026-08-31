<?/*
    ug
        kot/r/target-tpl/passes/passes-qy-tpl.vue.js.inc:12
        kot/r/target-tpl/passes/station-freq-tpl.vue.js.inc:33
*/?>
_vue.provider['__target-tpl'] = {

    provideOpt: {
        //addValidate: { dbg: 2 }
    },

    emits: [
        'onChange',
    ],

    data: function(){
        return {
            coverage: false,
            busyCoverage: false,

            ready: false,
        }
    },

    methods: {
        onReady(data){
            if (this.initData) {
                this.fetchInitData();
            } else {
                this.$emit('onChange', this.cfg)
            }

            this.ready = true;
            //this.calcCoverage();
        },

        fetchInitData(data){
            //if (!this.initData) return;

            //step: fetchInitData
            if (typeof this.initData === 'function') {
                this.initData.call(this)
            } else {
                this.fetchData(this.initData);
            }
        },

        fetchData(data){
            //this.log('fetchData@tt', { data: _cc(data) });
            _.merge(this.cfg, data, function(selfValue, newValue) {
                if (_.isUndefined(newValue)) {
                    return selfValue;
                }
            })
        },

        _addValidate: function(cfg){
            //_log('addValidate', { opt: _clone(cfg) });
            if (!cfg) cfg = {};
            var itemsProp = cfg.itemsProp || 'validateItems';

            return function addValidate(ref, name, ctx){
                //пересчёт в :ref происходит при каждом изменении реактивных данных
                if (this[itemsProp][name]) return; //поэтому отескаем добавление, если элемент уже добавлен
                if (!ctx) ctx = {};

                //this._log('addValidate', { name, ref, parName: this.name1, itemName: ref.name1 })

                if ((name === 'passes_min') && cfg.passes_min) {
                    //step: устанавливаем кастомный метод валидации
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

                if ((name === 'numFrom') && cfg.numFrom) {
                    ctx.isValid = function(value){
                        this.msgWarnCustom = '';
                        if (this.checkbox) {
                            if (this.value < 0) {
                                this.msgWarnCustom = 'Фиксированное поле не может быть меньше'
                                return false;
                            }
                        }
                        return true;
                    }
                }

                this[itemsProp][name] = _.assign({ ref, name }, ctx);
            }
        },


        _validate(cfg){
            //_log('validate/constructor', { opt: _clone(cfg) });
            if (!cfg) cfg = { itemsProp: 'validateItems' }
            var itemsProp = cfg.itemsProp || 'validateItems'


            return function(){
                //this.log('validate', { items: _cc(this[itemsProp]) });
                var self = this;
                var res = true;
                var itemRes;
                var setFocus = true;
                _.each(this[itemsProp], function(item){

                    itemRes = item.ref.validate({
                        validateOnChange: true,
                        stopValidateOnSuccess: true,
                        isValid: item.isValid,
                        /*isValid: item.isValid || function(value){
							//return value.length > 3; //dbg
							return value !== '';
						},*/
                    }, setFocus); //проставить фокус, если не он проставлен до этого

                    //self.log(`validate/each/${item.name}`, { 'ref.name': item.ref.name1, setFocus, itemRes, item: _cc(item) })

                    if (!itemRes && setFocus) setFocus = false; //убираем флаг 'проставить-фокус'

                    res *= itemRes;

                })

                return res;
            }
        },

        calcCoverage(){
            //this.log('calcCoverage@tt', { cfg: _clone(this.cfg) });
            var self = this;
            _r('targets', 'calcCoverage_aggregate', [this.cfg], {
                id: 0,
                busy: [this, 'busyCoverage'],
                next: function(coverageValue){
                    self.coverage = coverageValue;
                }
            })

        }


    },


    watch: {
        <? if (1) { ?>
            cfg: {
                deep: true,
                handler: function(val){
                    //_log('@w:cfg', { cfg: this.cfg, _cfg: _cc(this.cfg), ready: this.ready });
                    if (this.ready) {
                        //_log('onChange', { data: this.cfg });
                        this.$emit('onChange', this.cfg)
                    }
                }
            },
	    <? } else { ?>
            _cfg() {
                return {
                    deep: true,
                    handler: function(val){
                        //_log('w:cfg', { cfg: this.cfg, _cfg: _cc(this.cfg), ready: this.ready });
                        if (this.ready) {
                            //_log('onChange', { data: this.cfg });
                            this.$emit('onChange', this.cfg)
                        }
                    }
                },
            },
	    <? } ?>

        wait: {
            deep: true,
            handler: function (val) {
                var ready = _.every(this.wait); //проверяем каждое ли значение true
                //_log('w:wait', { ready, val: _clone(val) })
                if (ready) this.onReady();
            }
        }
    },

    mounted(){
        //this.log('@mounted', { ready: this.ready, onReady: this.onReady });
        if (this.ready) this.onReady(); //без ожидания (wait) w:wait не срабатывает
    }

}