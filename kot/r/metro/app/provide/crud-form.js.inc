<?/*
    ug
        { 'crud-form': {
            vuex: _Targets,
            apiBase: 'targets',
            rName: 'targets', //rootName | rName | parName |
            methods: {
                calcCoverage: true,
                update: true,
                create: true,
                fetchForm: {
                    next: function(item){
                        item.targets = _r('targets', 'prepareItemTargets', item.targets);
                        //_log('fetchForm/data', { item: _cc(item), targets: _cc(item.targets) });
                    }
                },
                //updateSavedValue: true,
                //reset: true
            }
        } }
*/?>

<? $js; ?>
//_vue.providerDep['crud-form'] = [''];

_vue.provider['__crud-form'] = function(__cfg){

    var _apiBase = __cfg.apiBase;
    var _Vuex = __cfg.vuex;
    var _rName = __cfg.rName;

    var _methods = __cfg.methods;
    _methods = _mapCfg(_methods, { cfgArg: __cfg });

    /*_.defaults(_methods, {
        updateSavedValue: true,
        isMode: true,
    })*/


    
    var _extension = {
        methods: {
            updateSavedValue: function(){
                var prev_savedFields = _clone(this.saved_fields);
                this.saved_fields = _clone(this.fields);
                ///_log('updateSavedValue', { prev_savedFields, savedFields: this.saved_fields, wasChanges: !_.isEqual(this.saved_fields, prev_savedFields) });
                //_log('updateSavedValue/hasChanges', { hasChanges: this.hasChanges });
            },

            isMode(name){
                return this.mode === name;
            },
        },

        computed: {
            hasChanges(){
                var isEqual = _.isEqual(this.saved_fields, this.fields);
                //_log('c:hasChanges', { isEqual, fields: _cc(this.fields), saved_fields: _cc(this.saved_fields) })
                return !isEqual;
            },
        }
    }
    
    var _src = {

        calcCoverage: function(then){
            var self = this;
            //_log('calcCoverage', { fields: _cc(this.fields) });

            //before()
            this.$refs.constructor.calcCoverage();

            _r(_rName, 'calcCoverage_aggregate', this.fields.targets, {
                id: this.fields.uid,
                busy: [this, 'busyCoverage'],
                next: function(coverageValue){
                    if (self.isMode('create')) {}
                    self.fields.forecast = coverageValue;
                    //then && setTimeout(then, 0);

                    then && then();
                }
            })
        },

        update: function(){
            var self = this;
            _r(_rName, 'itemUpdate', {
                id: this.fields.uid,
                fields: this.fields,
            }, {
                busy: [this, 'busyForm'],
                next: function(){
                    self.linkPar();
                }
            })
        },

        create: function(){
            var self = this;

            _r(_rName, 'itemCreate', this.fields, {
                busy: [this, 'busyForm'],
                next: function(){
                    self.linkPar();
                }
            })
        },

        //выставляем данные для компонента
        fetchForm: function(next){
            var self = this;
            var id = this.$route.params.id;

            var _cfg = _.defaults(_methods.fetchForm, { next: function(){} });
            _log('fetchForm/0', { _cfg: _cc(_cfg), _cfg0: _cc(_methods.fetchForm) })
            //_log('fetchForm', { id, route: this.$route });

            _Vuex.dispatch('itemGet', {
                uid: this.$route.params.id,
                busy: [this, 'busy'],
                next: function(item){
                    if (item) {
                        _cfg.next.call(self, item);

                        self.fields = item;

                        next && next(item)
                    }
                },
            });

        },

        reset: function(){},

    }




    _.each(_methods, function(_cfg, name){
        if (_src[name]) {
            _extension.methods[name] = _src[name];
        }
    })

    //_log('provide/crud-form', { __cfg, _methods, _apiBase, _Vuex, _extension })


    return _extension;
}