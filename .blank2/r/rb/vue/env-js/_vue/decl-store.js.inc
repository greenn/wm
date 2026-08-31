//3.1.20

var cfgStoreKeys = _cfg.store;
var _cfgStore = _cfg._store || {}; //дооплнительные настройки или команды

var dbg = name === 'drozd-rel';
//dbg && _Log('_vue/store/', { cfgStoreKeys, _cfgStore, name });

// nm
// nmIndex
if (cfgStoreKeys) {
    if (cfgStoreKeys === true) cfgStoreKeys = _.keys(decl.data());
    if (!_cfgStore.nm) _cfgStore.nm = name; //namespace

    var cfgStore = { //менеджер по работе с _cfgStore и cfgStoreKeys
        //получить namespace
        /*
            _store: {
                nm(){} - конструктор
                nmPreffix
                nmIndex() | {s} ak prop-name
            }
        */
        getCustomNamespace(self){
            if(!1) _Log('cfgStore/getCustomNamespace', {
                curIndex: _cmd.curIndex(),
                name
            })
            var nm = _cfgStore.nm;
            if (typeof nm === 'function'){
                nm = nm.call(self) //вызов конструктор с this
                    //плохо работает, т.к. даже data по-моему ещё не вызвается
            }
            //_Log('cfgStore/getCustomNamespace/1', { nm })

            var nmPreffix = _cfgStore.nmPreffix;
            if (nmPreffix) nm = `${nmPreffix}-${nm}`;

            //_Log('cfgStore/getCustomNamespace/2', { nm, nmPreffix })

            var _nmIndex = _cfgStore.nmIndex;
            var nmIndex;
            //_Log('cfgStore/getCustomNamespace/3', { nm, _nmIndex })
            if (_nmIndex) {
                if (typeof _nmIndex === 'function'){
                    nmIndex = _nmIndex.call(self);
                } else if (typeof _nmIndex === 'string'){
                    nmIndex = self[_nmIndex];
                }
                //_Log('cfgStore/getCustomNamespace/4', { nm, nmIndex })
            }
            if (nmIndex) nm += '.' + nmIndex;
            //_Log('cfgStore/getCustomNamespace/5', { nm })
            return nm;
        },

        getData(self){
            var nm = cfgStore.getCustomNamespace(self);
            //dbg && _Log('cfgStore/getData/nm/0', { nm })
            if (!nm) nm = name + '-' + _cmd.curIndex() + (self.name3 || ''); //base case
            //dbg && _Log('cfgStore/getData/nm/1', { nm, name3: self.name3, name3p: self.$props.name3, curIndex: _cmd.curIndex() })

            var _store = Store.get(nm) || {};
            //_Log('cfgStore/getData/2', { nm, _store, cfgStoreKeys, _cfgStore });

            var resetList = _cfgStore.reset;
            if (typeof resetList === 'function') {
                resetList = resetList();
            }
            if (resetList) {
                //here обнуляем указанные сохранённые данные
                _.each(resetList, function(key){
                    delete _store[key];
                })
                Store.set([nm], _store); //here сохраняе    м обновлённые (удалением) данные
            }
            return _store;
        },

        updateData(self, obj){

            //step: получаем данные их LocalStorage
            var _store = cfgStore.getData(self)

            //step: выставляем данные их LocalStorage
            _.each(cfgStoreKeys, function(key){
                if (_store.hasOwnProperty(key)) {
                    var storeValue = _store[key];
                    obj[key] = _.isPlainObject(storeValue) ? _.cloneDeep(storeValue) : storeValue;
                }
            });
            return obj;
        }
    }

    //_log('cfgStore', { cfg: cfgStore, store: _store });



    if (!_cfgStore.onMounted) {
        var og_data = decl.data;
        //step: добавляем в data локально-сохранённые значения
        decl.data = function(){
            var _values = og_data ? og_data.call(this) : {};
            //так понимаю что _data может и не быть если в decl не задано data(){}

            return cfgStore.updateData(this, _values);
        }
    }

    if (_cfgStore.onMounted) {
        //pr почему-то не работает, не заходит в decl.mounted
        var og_mounted = decl.mounted;
        //dbg && _Log('_vue/store/onMounted/0', { name, decl: _cc(decl), og_mounted })

        decl.mounted = function(){
            debugger;
            cfgStore.updateData(this, this);

            if (og_mounted) og_mounted.call(this);
        }
    }


    //step: подписываемся на обновление
    if (!decl.watch) decl.watch = {};
    _.each(cfgStoreKeys, function(key){
        var defMethod = decl.watch[key];
        var defMethodImmediate = false;
        //_Log('cfgStore/watch', { defMethod: _cc(defMethod), 'defMethod-type': typeof defMethod });
        if (typeof defMethod === 'object') {
            defMethodImmediate = defMethod.immediate;
            defMethod = defMethod.handler;
        }

        decl.watch[key] = {
            handler: function(newValue){
                var nm = cfgStore.getCustomNamespace(this);
                //_Log('cfgStore/upd', { name, nm, cfgStore, newValue});
                Store.set([nm, key], newValue);
                if (defMethod) defMethod.apply(this, arguments);
            },
            deep: true,
            immediate: defMethodImmediate,
        }
    })

}