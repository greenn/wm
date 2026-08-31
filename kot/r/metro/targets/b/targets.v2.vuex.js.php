<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp(
	'headers'
);
$Self = _kot::self();
//$n = $Self::nc();

$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	//$js['parallax'] = $Self::path('parallax', 'js.inc'),
	__FILE__
), SITE_CACHE);
?>

_Targets = (function(){

    var _log = Log.for('_Targets');

    //процесс выполнения экшенов
    var _act = function(set, body){
        var _set = makeSet(set);

        _set.busy(true);
        _delay(200, function(){
            var res = body(_set); //res 01
            _set.busy(false);
            res ? _set.next(res) : _set.next();
        })
    }

    return new Vuex.Store({
        state: {
            list: {}
        },

        mutations: {
            setList(state, list){
                _.each(list, function(item){
                    state.list[item.uid] = item
                })
            },

            removeFromList(state, uid) {
                delete state.list[uid];
            },

            addToList(state, item) {
                var uid = item.uid;
                state.list[uid] = item;
                //_log('addToList', { item, uid, list: _clearObject(state.list) })
            },

            setItemData(state, set) {
                state.list[set.uid] = set.item;
            },

            updateItemData(state, set) {
                //_log('updateItemData', { uid: set.uid, data: set.update, item: state.list[set.uid] })
                _.extend(state.list[set.uid], set.update);
            }
        },

        actions: {

            listLoad(ctx, set){
                var _set = makeSet(set);
                _set.busy(true);
                Api.request.get('targets/list', { tmp: moment().unix() },
                    function(response){
                        ctx.commit('setList', response.data.list)
                        //set.busy(false)
                        _set.busy(false);
                        _set.next(response);
                    }
                );
            },

            listLoad2(ctx, set){
                var list = [];
                Api.assignArray({
                    api: 'targets/list',
                    res: list,
                    busy: set.busy,
                    //dbg: true
                    cb: function(){
                        ctx.commit('setList', list)
                    }
                });
            },

            itemLoad: function(ctx, set){
                var _set = makeSet(set);
                _set.busy(true);
                Api.request.get('targets/item', {
                    id: _set('uid'),
                    tmp: moment().unix()
                }, function(response){
                    //_log('itemLoad/api', { response })
                    ctx.commit('addToList', response.data.item)
                    _set.busy(false);
                    _set.next(response);
                });
            },

            itemLoad2: function(ctx, set){
                var _set = makeSet(set);
                var item = {};
                Api.assignData({
                    api: 'targets/item',
                    data: { id: _set('uid') },
                    res: item,
                    dbg: true,
                    busy: _set.busy,
                    cb: function(response){
                        ctx.commit('addToList', item)
                        _set.next(response)
                    }
                });
            },


            itemGet: function(ctx, set){
                var dbg = !false;
                var _set = makeSet(set);

                var item = ctx.state.list[set.uid];
                if (0&& item) { //#P1-8#K8
                    if(dbg) _log('itemGet/case1/', { item: _cc(item) })
                    _act(set, function(_set){
                        _set.next(item);
                    });
                } else {
                    //if(dbg) _log('itemGet/case2/', { set: _set.ctx() })
                    _set.busy(true);
                    _Targets.dispatch('itemLoad', {
                        uid: _set('uid'),
                        next: function(response){
                            //if(dbg) _log('itemGet/case2/next', { item: response.data.item, response })
                            _set.next(response.data.item);
                            _set.busy(false);
                        },
                    });
                }
            },

            listRemove(ctx, set){
                _act(set, function(_set){
                    var item = _set('item');
                    ctx.commit('removeFromList', item.uid);
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
                    //_log('itemSet', { uid: item.uid, item: item });
                    ctx.commit('setItemData', {
                        uid: item.uid,
                        item: item
                    });
                })
            },

            itemUpdate: function(ctx, set){
                _act(set, function(_set){
                    var update = _set('update') //itemData|update
                    //_log('itemUpdate', { set, _set, update })
                    var updateData = {
                        uid: update.uid,
                        update: update.data
                    }
                    if(0) _set.extend({
                        nextArgs: updateData
                    })
                    ctx.commit('updateItemData', updateData);
                })
            },

        },


        getters: {
            getList(state){ //002
                return _.sortBy(state.list, ['uid']);
                //_log('getList', { sortList: _.sortBy(state.list, ['uid']) })
                //return _.values(_.sortBy(state.list, ['uid']))
            },

            //_Targets.getters.getItem(uid);
            getItem: function(state) {
                return function(uid) {
                    if (!state.list[uid]) {
                        _Targets.dispatch('itemLoad', { uid: uid })
                    }
                    return state.list[uid];
                };
            },

        },
    })

})()