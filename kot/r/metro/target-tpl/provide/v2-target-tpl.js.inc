<?/*
    ug
        kot/r/target-tpl/passes/passes-qy-tpl.vue.js.inc:12
        kot/r/target-tpl/passes/station-freq-tpl.vue.js.inc:33
*/?>
_vue.providerDep['v2-target-tpl'] = ['target-tpl'];

_vue.provider['__v2-target-tpl'] = function(__cfg){
    var _listCfg = __cfg.list;
    var _selectCfg = __cfg.select;
    //_log('@v2-target-tpl/extender', { __cfg: _cc(__cfg), _listCfg, _selectCfg })


    var _extension = {

        provideOpt: {
            //addValidate: { dbg: 2 }
        },

        /*_vue: {
            multiInstances: true,
        },*/

        emits: [
            'onRemove',
            'onChange',
        ],

        props: [
            'initData',
            'trgName'
        ],

        data(_cfg){
            //_log('@v2-target-tpl/data-constuctor', { __cfg: _cc(__cfg) })
            var cfg = {
                id: 0,
                name: this.$props.trgName,
            };

            var data =  {
                cfg: cfg,
                validateItems: {},



                wait: {
                    select: false,
                },
                ready: false,
            }


            if (_selectCfg) {
                cfg.value = '';

                _.extend(data, {
                    busy: false,
                    options: [],
                    optionsInfo: {},
                })
            }

            if (_listCfg) {
                cfg.list = ''; //ошибка если list:[]

                _.extend(data, {
                    busy: false,
                    options: [],
                    optionsInfo: {},
                })
            }

            //_log('@v2-target-tpl/data-constuctor/res', { _data: _cc(data) })

            return data;

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
                _log('@v2-target-tpl/loadOptions', { __cfg: _cc(__cfg) })
                var self = this;
                _r('ui', _cfg.fn || 'selectCardFactor_getOptions', {
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


    }

    if (_selectCfg) {

        _extension.data = function () {
            return {
                /*cfg: @props
                    'value': '',
                */

                info: {},
                busy: false,
            }
        }

        if (!_extension.methods) _extension.methods = {};

        _extension.methods.loadData = function(next){
            var self = this;

            _r('ui', _selectCfg.api, {
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

        _extension.mounted = function(){
            this.loadData();
        }

    }

    if (_listCfg) {
        if (!_extension.methods) _extension.methods = {};

        _extension.methods.loadOptions = function(next){
            var self = this;
            _r('ui', _listCfg.api, {
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

        _extension.mounted = function(){
            this.loadOptions();
        }

    }


    return _extension;
}