<?/*ug*/ if (0) { ?>
@provide = { 'crud-item': {
    vuex: _Targets,
        rName: 'targets',
        routeName: 'target-item',

        methods: {
        calcCoverage: {
            after: function(){
                this.$refs.targets.calcCoverage();
            }
        },
        aproove: true,
            reject: true,
            copy: true,
            remove: {
            before: function(){
                this.underDelete = this.item.uid;
            },
            next: function(){
                //this.underDelete = false;
                this.linkPar();
            },
        },
        fetchItem: {
            next: function(item){
                //_log('fetchItem/s:itemGet/qpr', { uid: this.$route.params.id, item})
                if (item) { /*[pr] происходит какое-то второе срабатывание поэтому проверка */
                    item.targets = _r('targets', 'prepareItemTargets', item.targets);
                    this.item = item;

                    this.calcCoverage();
                }
            }
        },
    },

} }
<? } ?>

<? $js; ?>
//_vue.providerDep['crud-item'] = [''];

_vue.provider['__crud-item'] = function(__cfg){

    var _Vuex = __cfg.vuex;
    var _rName = __cfg.rName;

    var _methods = __cfg.methods;
    _methods = _mapCfg(_methods, { cfgArg: __cfg });

    var _extension = {
        methods: {
            fetchItem: function () {
                var self = this;
                var id = this.$route.params.id;
                //_log('fetchItem', { id, route: this.$route });
                //var _cfg = _.defaults(_methods.fetchItem, { next: function(){} });
                var _cfg = _methods.fetchItem;

                _Vuex.dispatch('itemGet', {
                    uid: id,
                    busy: [this, 'busy'],
                    next: function (item) {
                        if (_cfg.next) {
                            _cfg.next.call(self, item);
                        } else {
                            //case def
                            self.item = item;
                        }
                    },
                });
            }

        },

        watch: {
            $route: function(route){
                //_log('w:route', { route })
                if (route.name === __cfg.routeName) {
                    this.fetchItem();
                }
            },
        },

        mounted(){
            //_log('mounted/@crud-item', { this: this, self: _cc(this) })
            this.fetchItem();
        }
    }
    
    var _src = {

        calcCoverage: function(){
            var _cfg = _.defaults(_methods.calcCoverage, { after: function(){} });

            _r(_rName, 'calcCoverage', this.item.uid, {
                busy: [this, 'busyCoverage'],
                //next: function(){}
            })

            _cfg.after.call(this);
        },

        aproove: function(){
            var self = this;
            //_log('aproove', { item: this.item });
            _r(_rName, 'itemAproove_popup', this.item, {
                busy: [self, 'busy'], //показать свою крутилку
                next: function(response){
                    self.fetchItem(); //#K9
                }
            });
        },

        reject: function(){
            var self = this;
            //_log('reject', { item: this.item });
            _r(_rName, 'itemReject_popup', this.item, {
                busy: [self, 'busy'], //показать свою крутилку
                next: function(response){
                    self.fetchItem(); //#K9
                }
            });
        },

        copy: function(){
            var self = this;
            //_log('copy', { item: this.item });
            _r(_rName, 'itemCopy_popup', this.item, {
                busy: [self, 'busy'], //показать свою крутилку
                next: function(response){
                    //_log('copy/response', { response });
                    self.linkRel(response.data['new-id']);
                },
            });
        },

        remove: function(){
            var _cfg = _.defaults(_methods.remove, { before: function(){} });

            var self = this;
            //_log('remove', { item: this.item });

            _cfg.before.call(this);

            _r(_rName, 'itemRemove_popup', this.item, {
                busy: [self, 'busy'], //показать свою крутилку
                next: function(){
                    _callCfg(_cfg.next, [self], function(){
                        this.linkPar();
                    }, !true)

                    /*
                    if (_cfg.next) {
                        _cfg.next.call(self);
                    } else {
                        //case def
                        self.linkPar();
                    }
                    */
                }
            });
        }

    }

    //добавляем src-методы, только те, что указаныв в конфиге __cfg.methods
    _.each(_methods, function(_cfg, name){
        if (_src[name]) {
            _extension.methods[name] = _src[name];
        }
    })

    //_log('@provide/crud-item', { __cfg, _extension })


    return _extension;
}