//5.7.1526
function isObject(value) {
    //return value && value.constructor === Object; //[bg не работает если объект создан как ¦new function(){}¦]
    return !isArray(value) && (typeof value === "object");
}
function isArray(value) {
    return value && value.constructor === Array;
}
function isString(value) {
    return typeof(value) == 'string';
}

//let WebStorage =
_storage = {
    data: {},
    hasPath: function(path){ //clone of getPath
        var keys = path.slice(0);
        var key = keys.shift();
        if (this.data.hasOwnProperty(key)) {
            var objValue = this.data[key];
            for (var index in keys) {
                var subKey = keys[index];
                if (isObject(objValue) && objValue.hasOwnProperty(subKey)) {
                    objValue = objValue[subKey];
                } else {
                    return false;
                }
            }
        }
        return true;
    },
    getPath: function(path, otherwise){
        var keys = path.slice(0);
        var key = keys.shift();
        if (this.data.hasOwnProperty(key)) {
            var objValue = this.data[key];
            for (var index in keys) {
                var subKey = keys[index];
                if (isObject(objValue) && objValue.hasOwnProperty(subKey)) {
                    objValue = objValue[subKey];
                } else {
                    return otherwise;
                }
            }
            return objValue;
        } else {
            return otherwise;
        }
    },
    get: function(key, otherwise){
        if (isArray(key)) {
            return this.getPath(key, otherwise);
        }

        var value = this.data.hasOwnProperty(key) ? this.data[key] : otherwise;
        return value;
    },
    savePath: function(path, value){
        var keys = path.slice(0);
        var key = keys.shift();
        var subValue, objValue = subValue = !this.data.hasOwnProperty(key)
            ? {} : isObject(this.get(key))
                ? this.get(key) : { '\\0': this.get(key) }
        ;

        for (var index in keys) {
            var subKey = keys[index];
            if (subKey === '') subKey = '\'\'';
            else if (!isString(subKey)) subKey = new String(keys[index]).toString();

            if (keys.length == +index + 1) {
                subValue[subKey] = value;
            } else {
                if (!isObject(subValue[subKey])) {
                    subValue[subKey] = { '\\0': subValue[subKey] };
                }
                subValue = subValue[subKey];
            }
        }
        //console.log('_storage/savePath', { key, objValue });


        return this.save(key, objValue);
    },
    save: function(key, value){
        if (isArray(key)) {
            return this.savePath(key, value);
        }

        var jsonValue = JSON.stringify(value);

        //console.log('_storage/save', { key, value, jsonValue});

        localStorage.setItem(key, jsonValue);
        return this;
    },

    removePath: function(path){
        var keys = path.slice(0);
        var key = keys.shift();
        var subValue, objValue = subValue = this.get(key);
        for (var index in keys) {
            var subKey = keys[index];
            if (isObject(subValue) && subValue.hasOwnProperty(subKey)) {
                if (keys.length == +index + 1) {
                    delete subValue[subKey];
                } else {
                    subValue = subValue[subKey];
                }
            } else {
                return false;
            }
        }
        return this.save(key, objValue);
    },
    remove: function(key){
        if (isArray(key)) {
            return this.removePath(key);
        }

        localStorage.removeItem(key);
        return this;
    },
    update: function(){
        //console.log('localStorage', [localStorage]);
        for (var key in localStorage) {
            var jsonValue = localStorage.getItem(key);
            var value;
            try {
                value = JSON.parse(jsonValue);
            } catch (e) {
                value = jsonValue;
            }
            this.data[key] = value;
        }
        return this;
    },

    observables: {},
    observable: function(path, defaultValue){
        var name = new String(path).toString();
        var hasValue = this.hasPath(path)
        var koObservable = this.observables[name] = ko.observable(hasValue ? this.get(path) : defaultValue);
        koObservable.subscribe(function(value){
            _storage.save(path, value);
        });
        if (!hasValue) koObservable.valueHasMutated();
        return koObservable;
    },

    namespaceHandler: function(nm){
        var namepace = [nm];

        return {
            set: function(path, value){
                _storage.save(namepace.concat(path), value);
            },
            get: function(){
                var path = arguments.length === 1 ? arguments[0] : Array.prototype.slice.call(arguments);
                return _storage.get(namepace.concat(path));
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
    }

}.update();

//c('{storage}', _storage.data);

/*

    общий размер
        about 5MB
            g js localstorage size

    c(
        _storage.save(["prod_saver-s2", "", false, null], 10),
        _storage
    );

    c(
        //_storage.save('_', { a: { b: { c: 3 }} }),

        //_storage.remove(['_', 'a', 'b', 'c']),

        _storage.save(['_', 'a', 'b'], 10),

        //_storageGet(['_', 'a', 'b', 'c'])
        _storage.get(['_', 'a'])
    );
*/