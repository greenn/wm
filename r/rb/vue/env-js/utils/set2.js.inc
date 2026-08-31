<?/* #2.1
    set = _set(set);

    set.next(); - вызов стека функций next()
    set.busy(true); - вызов boolean-функций busy()
    set('item') - получение значение из внутреннего контекста

    set.extend({}); - расширение/добавление данных в контекст
*/?>

var makeSet_ = function(data, dataN){
    var set = makeSet(data);
    for (var i = 1; i < arguments.length; i++) {
        set.extend(arguments[i]);
    }
    return set;
}

var makeSet = function(data){

    //case: data уже есть makeSet
    if (typeof data === 'function' && data.name === '_set2') return data;

    //если данные просто функция, то видим её как колбек next
    if (typeof data === 'function') {
        data = { next: data }
    }

    //var ctx = _clone(data);
    var _ctx = data || {}; //storage

    var _self = function _set2(prop){
        //return prop ? _ctx[prop] : _ctx;
        return !arguments.length ? _self.ctx() : _self.prop_(arguments);
    };

    _self.ctx = function(){ return _ctx }

    _self.prop1 = function(prop){ return _ctx[prop] } //[lde]

    _self.prop = function(...args){ return _.get(_ctx, args) }

    _self.prop_ = function(args){
        return _self.prop.apply(_self, args)
    }

    _self.val1 = function(prop, otherwise){ //[lde]
        return _ctx.hasOwnProperty(prop) ? _ctx[prop] : otherwise
    }
    _self.val = function(prop/*[props]*/, otherwise){
        var props = _.castArray(prop);
        return _.get(_ctx, props, otherwise)
        //return _.has(_ctx, props) _self.prop_(props) : otherwise
    }

    _self.extend = function(ctx){
        _extendProp(_ctx, ctx)
        return _self;
    }

    _self.busy = function(state){
        _setBusy(_ctx, state);
    }



    _self.next = function(){
        return _self.call('next', arguments, 'nextArgs')
    }

    //вызыватор ak next
    _self.call = function(prop, args, argsProp){
        args = _.toArray(args);
        if (argsProp) {
            if (argsProp === true) argsProp = prop + 'Args'; //ak nextArgs | successArgs
            var setArgs = _self.val(argsProp);
            if (setArgs) args = _.concat(args, setArgs);
        }
        return _callProp(_ctx, 'next', args)
    }

        _self.next1 = function(){
            var args = _.toArray(arguments);
            var setArgs = _self.val('nextArgs', arguments);
            //_log('makeSet/next', { args: _clone(args), setArgs: _clone(setArgs) })

            if (setArgs) args = _.concat(args, setArgs);

            return _callProp(_ctx, 'next', args)
        }


    //eg _set.fetch(this, ['isValid', 'validateOnChange', 'stopValidateOnSuccess'])
    _self.fetchCfg = function(self, cfg, name){

    }
    _self.fetch = function(self, props){
        if (_.isPlainObject(props)) {
            _.each(props, function(cfg, name){
                if (_ctx.hasOwnProperty(name)) {
                    var value = _ctx[name];
                    if (cfg === true) cfg = name; //~ cfg = { prop: name };
                    if (typeof cfg === 'string') cfg = { prop: cfg };
                    else if (typeof cfg === 'function') cfg = { prop: name, handler: cfg };
                    self[cfg.prop] = cfg.handler ? cfg.handler.call(self, value) : value
                }
            })
        } else {
            _.each(props, function(prop){

                if (_ctx.hasOwnProperty(prop)) {
                    //_log('SET/FETCH/each', { prop, value: _ctx[prop] })
                    if (_ctx[prop] !== undefined) {
                        self[prop] = _ctx[prop]
                    }
                }
            })
        }
    }

    return _self;

}