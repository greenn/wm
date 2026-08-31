//3.1.1240
//const Store = _storage.namespaceHandler('<?=pro('sid')?>');
const Store = (function(){

    var namepace = ['<?=pro('sid')?>'];

    return {
        set: function(path, value){
            _storage.save(namepace.concat(path), value);
        },
        get: function(){
            var path = arguments.length === 1 ? arguments[0] : Array.prototype.slice.call(arguments);
            return _storage.get(namepace.concat(path));
        },
        getOr: function(path, otherwise){
            return _storage.get(namepace.concat(path), otherwise);
        },
        remove: function(path){
            _storage.remove(namepace.concat(path));
        },
        dbg: function(doReturn){
            var data = _storage.get(namepace);
            if (doReturn) return { namepace, store: data };
            console.log('(dbg)Store', namepace, data); //this.get([])
        },

        observable: function(subPath, defValue){
            var path = namepace.concat(subPath);
            //console.log('(Store)', path, this.get([]), localStorage);
            return _storage.observable(path, defValue);
        }
    }

})();

let _Store;