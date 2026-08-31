
<?/*            какой-то объект SET


*/?>

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
            //case: если функция, то делаем стек функций
            var fn = base[name];
            base[name] = [fn, value]
        } else {


            //сделать merge 2ух Jобъектов, и заменить поля, если есть совпадения
            var merge1 = _.mergeWith({}, base[name], value, function (objValue, srcValue) {
                // Заменяем значение, если свойство уже существует
                if (_.has(base[name], objValue)) {
                    return srcValue;
                }

                // Возвращаем undefined, чтобы Lodash использовал стандартное слияние
                return undefined;
            });
            _.merge(base[name], value, function(valBase, valExt, name, propBase, propExt){
                _log('_extendProp/merge', { sameProp: name, valBase, valExt,propBase, propExt })
            })


            console.log(mergedObject);

            _log('_extendProp/dd case', { value1: base[name], value2: value, data0: base, data1: data, merge1 })
        }
    })
}

//вызываем свойство, как функцию или набор функций
var _callProp = function(obj, prop, callArgs){
    var _fn = obj ? obj[prop] : prop;
    _.each(_.castArray(_fn), function(fn){
        //_log('_callProp/each', { obj, prop, callArgs, fn })
        fn && fn.apply(null, callArgs || [])
    })
}


<? //include $js['utils/set1']; //useSet ?>

<? include $js['utils/set2'] /*
    makeSet(),
    makeSet_()
 */?>

var _set = makeSet;

var _mapCfg = function(input, set){ //_mapCfgArray
    var output = input;
    ///_log('_mapCfg/output/0', { output: _cc(output) })

    if (!set) set = {};

    if (_.isArray(input)) output = _.transform(input, function(res, item){
        if (_.isPlainObject(item)) _.assign(res, item);
        else if (_.isFunction(item)) _.assign(res, item());
        else if (item && _.isString(item)) res[item] = true;
    }, {});
    ///_log('_mapCfg/output/1', { output: _cc(output) })

    if (_.isPlainObject(output)) {
        output = _.transform(output, function(res, cfg, name){
            if (cfg === true) cfg = {};
            else if (_.isFunction(cfg)) cfg = cfg(set.cfgArg);

            if (cfg) {
                res[name] = cfg;
            } //case Else: при false|null|undefined
        }, {})
    }
    ///_log('_mapCfg/output/2', { output: _cc(output) })

    return output;
}

//вызываем метод, если он есть, или другой метод по умолчанию
<?/*
_callCfg([__cfg.methods, 'remove', 'next'], [self], function(){ this.linkPar(); }, true)
_callCfg([__cfg.methods, ['remove', 'next']], [self], function(){ this.linkPar(); }, true)
*/?>
var _callCfg = function(method, callCtx, otherwise, anyway){
    if (_.isArray(method)) {
        var obj = method[0];
        var prop = method.slice(1);
        if (prop.length === 1) prop = prop[0];
        method = _.get(obj, prop)
    }
    if (method) {
        method.call(callCtx[0], callCtx[1]);
    }
    if (otherwise) {
        if (!method || anyway) {
            otherwise.call(callCtx[0], callCtx[1]);
        }
    }
}