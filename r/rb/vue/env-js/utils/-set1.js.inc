if (0) {///007B

    var _madeBusy = function(set){
        var setBusy;
        if (typeof set.busy === 'function')  { //case 1
            setBusy = set.busy;
        } else {
            if (set.busy === true) set.busy = 'busy'; //case 2.2
            setBusy = function(state){
                var _this, _prop;
                if (_.isArray(set.busy)) { //case 3
                    //_log('_madeBusy/case 3'); //DBG
                    _this = set.busy[0];
                    _prop = set.busy[1] || 'busy'; // ||~ case 3.2
                } else { //case 2
                    _this = set.this;
                    _prop = set.busy;
                }
                //_log('setBusy', { state, _this: [_this && _this._name, _this], _prop, cur_val: _this[_prop], new_val: state })
                if (_this) {
                    _this[_prop] = state;
                }
            }
        }

        return setBusy
    }
    var _setBusy = function(set, state){
        _madeBusy(set)(state);
    }


    //_extendProp(set, { next: next });
    var _extendProp = function(base, data){
        _.each(data, function(value, name){
            if (!base[name]) base[name] = value;
            else if (typeof base[name] === 'function') {
                var fn = base[name];
                base[name] = [fn, value]
            } else {
                _log('_extendProp/dd case', { value1: base[name], value2: value, data0: base, data1: data })
            }
        })
    }

    var _callProp = function(obj, prop){
        var _fn = arguments.length === 1 ? obj : obj[prop];
        _.each(_.castArray(_fn), function(fn){
            fn && fn.call()
        })
    }

}

<?/*            какой-то объект SET

        set = _set(set);
    set = _Set(set);
    var _set = _Set(set);

    set({ item: {} }) - вызываем расширение внутреннего контекст
    set.next(); - вызов стека функций next()
    set.busy(true); - вызов boolean-функций busy()
    set.item - получение значение из внутреннего контекста


        if (set instanceof _set) return _set
    set.next();
    set.busy(true);


        set.set(set) ~ _extendProp(set, { next: closePopup });
    _set(set) ~ _extendProp(_set, set._ctx());


    tt
        var set = newSet({ next: function(){ console.log('11') }})
        var set2 = newSet(set)
        set2({ next: function(){ console.log('12') }})
        var set3 = newSet(set2)
        set3.next()


*/?>
<?/*
    var _Set = function(data) {
        return data instanceof Set ? data : new Set(data);
    }


    var Set = function(data){
        var storage = data;
        var busy = _madeBusy(data)
        return new Proxy(storage, {
            get busy() {
                return busy
            },
        });
    }
*/?>

var useSet = function(data){ //newSet|useSet|_set_
    if (arguments.length > 1) {
        var set = newSet(data);
        for (var i = 1; i < arguments.length; i++) {
            set(arguments[i]);
        }
        return set;
    }

    //case уже data есть newSet
    if (typeof data === 'function' && data.name === '_set') return data;

    //var ctx = _clone(data);
    var _ctx = data; //storage

    var _proxy;
    var _self = function _set(data){
        if (typeof data === 'function' && data.name === '_set') {
            data = data._ctx();
        }
        _extendProp(_ctx, data)
        return _proxy;
    };

    _self.extend = function(ctx){
        _extendProp(_ctx, ctx)
    }
    _self._ctx = function(){ return _ctx }
    _self.busy = _madeBusy(_ctx);
    _self.next = function(){
        return _callProp(_ctx, 'next')
    }

    _self.propVal = function(name, otherwise){
        return _ctx.hasOwnProperty(name) ? _ctx[name] : otherwise
    }
    _self.prop = function(name, value){
        if (arguments.lentgh === 1) {
            return _ctx[name];
        } else {
            return _ctx[name] = value;
        }
    }

    //return _self;
    _proxy = new Proxy(_self, {
        get(self, name) {
            _log('_set/proxy', { name, _self, _ctx })
            return _self[name] ? _self[name] : _ctx[name];
        },

        set(self, name, value) {
            return _ctx[name] = value;
        }
    })

    return _proxy;

}