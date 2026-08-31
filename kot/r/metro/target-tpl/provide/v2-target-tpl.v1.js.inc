<?/*
    ug
        kot/r/target-tpl/passes/passes-qy-tpl.vue.js.inc:12
        kot/r/target-tpl/passes/station-freq-tpl.vue.js.inc:33
*/?>
_vue.providerDep['v2-target-tpl'] = ['__target-tpl'];

_vue.provider['__v2-target-tpl'] = {

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

    _data(_cfg){
        _log('@v2-target-tpl/data-constuctor', { _cfg: _cc(_cfg) })
        return function data(){
            var cfg = {
                id: 0,
                name: this.$props.trgName,

                list: '', //ошиька при list:[]
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

        _loadOptions(_cfg){
            _log('@v2-target-tpl/loadOptions', { _cfg: _cc(_cfg) })
            return function loadOptions(next){
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
        }
    },


    watch: {
        //cfg() @provide target-tpl2 //dbg
    },



    mounted(){
        //mounted @provide target-tpl2
        //this.log('@mounted', { ready: this.ready, onReady: this.onReady });
        this.loadInfo();
    },

}