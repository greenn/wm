
var cfgStore = _cfg.store;
var _cfgStore = _cfg._store || {}; //дооплнительные настройки или команды
/// _cfg.store
if (cfgStore) {
    if (cfgStore === true) cfgStore = _.keys(decl.data());
    if (_.isArray(cfgStore)) cfgStore = {
        // namespace: name,
        keys: cfgStore,
    }

    if (!cfgStore.namespace) cfgStore.namespace = name;
    cfgStore.nm = function(data){
        var nm = this.namespace;
        var nm_index = this.propIndex && data[this.propIndex];
        if (nm_index) nm += '.' + nm_index;
        return nm;
    }


    //_log('cfgStore', { cfg: cfgStore, store: _store });

    //step: добавляем в data локально-сохранённые значения
    decl.data = function(){
        var _values = _data(); //так понимаю что _data может и не быть если в decl не задано data(){}

        var nm = cfgStore.nm(_values);
        var _store = Store.get(nm) || {};
        //_Log('cfgStore', { nm, store: _store, cfgStore, _cfgStore });
        if (_cfgStore.reset) {
            _.each(_cfgStore.reset, function(key){
                delete _store[key];
            })
            Store.set([nm], _store);
        }


        _.each(cfgStore.keys, function(key){
            if (_store.hasOwnProperty(key)) {
                _values[key] = _store[key]
            }
        })
        return _values;
    }

    //step: подписываемся на обновление
    if (!decl.watch) decl.watch = {};
    _.each(cfgStore.keys, function(key){
        var defMethod = decl.watch[key];

        decl.watch[key] = {
            handler: function(newValue){
                var nm = cfgStore.nm(this);
                _Log('store-upd', [name, nm], { cfgStore, newValue});
                //Store.set([nm, key], newValue);
                if (defMethod) defMethod.apply(this, arguments);
            },
            deep: true,
        }
    })

}