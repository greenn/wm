<?/*
    ug
        kot/r/target-tpl/passes/passes-qy-tpl.vue.js.inc:12
        kot/r/target-tpl/passes/station-freq-tpl.vue.js.inc:33
*/?>
_vue.providerDep['v2-target-tpl2'] = ['target-tpl2'];

_vue.provider['__v2-target-tpl2'] = function(__cfg){
    var _listCfg = __cfg.list;
    var _selectCfg = __cfg.select;
    //_log('@v2-target-tpl2/extender', { __cfg: _cc(__cfg), _listCfg, _selectCfg })

    var _extension = {

        /*_vue: {
            multiInstances: true,
            provide: [
                'target-tpl2',
            ],
        },*/

        props: ['cfg'],

        /*data(){
            return {
            //@provide target-tpl2
                //coverage: false,
                //busyCoverage: false,
            }
        },*/

        methods: {
            //calcCoverage() @provide target-tpl2
        },

        watch: {
            //cfg() @provide target-tpl2 //dbg
        },

        //mounted @provide target-tpl2
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

        if (!_extension.computed) _extension.computed = {};
        _extension.computed.title = function(){
            return _.get(this, ['info', this.cfg.value, 'text'], '-');
        }

        _extension.mounted = function(){
            var self = this;
            _r('ui', _selectCfg.api, {
                busy: [self, 'busy'],
                next: function(options, optionsInfo){
                    //_log('options/res', { optionsInfo })
                    self.info = optionsInfo;
                }
            })
        }

    }


    if (_listCfg) {

        _extension.data = function(){
            return {
                /*cfg: @props
                    'list': '',
                */

                info: {},
                busy: false,
            }
        }

        if (!_extension.methods) _extension.methods = {};
        _extension.methods.loadInfo = function(){
            var self = this;
            _r('ui', _listCfg.api, {
                busy: [self, 'busy'],
                next: function(options, optionsInfo){
                    //_log('loadData', { options, optionsInfo })
                    self.info = optionsInfo;
                }
            })
        }

        _extension.mounted = function(){
            this.loadInfo();
        }
    }

    return _extension;
}