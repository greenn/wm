<?#1.0.1 ?>
<?/*
https://www.youtube.com/watch?v=c2SK1IlmYL8

var _Targets = new Vuex.Store(vuexCfg({
    self: function(){ return _Targets },
    logTitle: '_Targets',
    actDelay: 200,
    idnProp: 'uid',
    api: {
        list: 'targets/list',
        item: 'targets/item',
    }
}))

computed: {
    list2() {
        return _Targets.state.list; // Получение списка из хранилища
    },
    list3() {
        return _Targets.getters.getList;
    }
},

mounted() {
    //_Targets.dispatch('listLoad');
}

*/?>

var vuexCfg = function(__){

    var _idnProp = __.idnProp;
    //step: prepareApi
    __.api = _.transform(__.api, function(res, cfg, name){
        if (_.isString(cfg)) cfg = { uri: cfg, method: 'get', data: {} }
        if (_.isArray(cfg)) {}

        res[name] = cfg;
    }, {})

    /*
    var __api = function(apiName, set, success){
        var _api = __.api[apiName];
        var _data = _.isFunction(_api.data) ? _api.data(set) : _api.data;
        _data.tmp = moment().unix();

        Api.request(_api.method, _api.uri, _data, success);
    }
    */


    var _log = Log.for(__.logTitle);

    //процесс выполнения экшенов
    var _act = function(set, process){
        var _set = makeSet(set);

        _set.busy(true);
        _delay(__.actDelay, function(){
            var res = process(_set); //res 01
            _set.busy(false);
            res ? _set.next(res) : _set.next();
        })
    }

    return {
        state: {
            list: {}
        },

        mutations: {
            setList(state, list){
                _.each(list, function(item){
                    var idn = item[_idnProp]
                    state.list[idn] = item
                })
            },

            removeFromList(state, idn) {
                delete state.list[idn];
            },

            addToList(state, item) {
                //_log('addToList', { item, _idnProp, list: _cc(state.list) })
                var idn = item[_idnProp]
                state.list[idn] = item;
            },

            setItemData(state, set) {
                var idn = set[_idnProp];
                var item = set.item;
                state.list[idn] = item;
            },

            updateItemData(state, set) {
                var idn = set[_idnProp];
                var data = set.update;
                //_log('updateItemData', { idn, data, item: _cc(state.list[idn]) })
                _.extend(state.list[idn], data);
            }
        },

        actions: {

            listLoad(ctx, set){
                var _set = makeSet(set);
                _set.busy(true);

                var _api = __.api.list;
                //_log('listLoad', { __, _api })
                Api.request(_api.method, _api.uri, { tmp: moment().unix() },
                    function(response){
                        //_log('listLoad/res', { response })
                        ctx.commit('setList', response.data.list)
                        //set.busy(false)
                        _set.busy(false);
                        _set.next(response);
                    }, {
                        emu: true
                    }
                );
            },

            itemLoad: function(ctx, set){
                var _set = makeSet(set);
                //var idn = set[_idnProp]
                var idn = _set(_idnProp)

                _set.busy(true);

                var _api = __.api.item;
                Api.request(_api.method, _api.uri, {
                    id: idn, //получение переданного idn через set
                    tmp: moment().unix()
                }, function(response){
                    //_log('itemLoad/api', { idn, _api, response, _set: _set.ctx() })
                    ctx.commit('addToList', response.data.item)
                    _set.busy(false);
                    _set.next(response);
                }, {
                    emu: true
                });
            },

            itemGet: function(ctx, set){
                var dbg = !false;
                var _set = makeSet(set);
                var idn = _set(_idnProp);

                var item = ctx.state.list[idn];
                if (0&& item) {//pr какие-то с этим есть проблемы

                    if(dbg) _log('itemGet/case1/', { item: _cc(item) })

                    _act(set, function(_set){
                        _set.next(item);
                    });

                } else {
                    //if(dbg) _log('itemGet/case2/', { set: _set.ctx() })
                    _set.busy(true);

                    var cfg = {};
                    cfg[_idnProp] = idn;
                    cfg.next = function (response) {
                        _set.next(response.data.item);
                        _set.busy(false);
                    }

                    var _Self = __.self();
                    _Self.dispatch('itemLoad', cfg)
                }
            },

            listRemove(ctx, set){
                _act(set, function(_set){
                    var item = _set('item');
                    var idn = item[_idnProp];
                    ctx.commit('removeFromList', idn);
                });
            },

            listAdd(ctx, set){
                _act(set, function(_set){
                    //ctx.commit('addToList', _set('item'));
                })
            },


            itemSet: function(ctx, set){
                _act(set, function(_set){
                    var item = _set('item')
                    _log('itemSet', { uid: item.uid, item: item });

                    var cfg = {};
                    cfg[_idnProp] = item[_idnProp];
                    cfg.item = item;

                    ctx.commit('setItemData', cfg);
                })
            },

            itemUpdate: function(ctx, set){
                _act(set, function(_set){
                    var update = _set('update');
                    //_log('itemUpdate', { set, _set, update })
                    var updateData = {};
                    updateData[_idnProp] = update[_idnProp];
                    updateData.update = update.data;

                    if(0) _set.extend({
                        nextArgs: updateData
                    })
                    ctx.commit('updateItemData', updateData);
                })
            },

        },


        getters: {
            getList(state){ //002
                return _.sortBy(state.list, [_idnProp]);
                //_log('getList', { sortList: _.sortBy(state.list, ['uid']) })
                //return _.values(_.sortBy(state.list, ['uid']))
            },

            //_Targets.getters.getItem(uid);
            getItem: function(state) {
                //_log('vuex/getters/getItem', { state: _cc(state) });
                return function(idn) {
                    if (!state.list[idn]) {
                        var cfg = {};
                        cfg[_idnProp] = idn
                        var _Self = __.self();
                        _Self.dispatch('itemLoad', cfg)
                    }
                    return state.list[idn];
                };
            },

        }
    }

}