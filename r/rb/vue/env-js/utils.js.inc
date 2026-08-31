//oj - по-моему очень странный дебаунс
var _debounce = function(fn, timeout){
    clearTimeout(_debounce.tm);
    _debounce.tm = setTimeout(function(){
        _debounce.tm = null;
        fn();
    }, timeout);
}



var _clearObject = function(data){
    return _.transform(data, function(res, value, key){
        res[key] = _.isObjectLike(value) ? _clearObject(value) : value
    }, _.isArray(data) ? [] : {});
}
var _cc = _clearObject;

var _clone = function(data){
    return _.cloneDeep(data)
}
var _clone2 = function(data){
    return _.merge({}, data)
}

var _pickAttrs = function(set, allow){
    var attrs = {};
    _.each(allow, function(name){
        if (set.hasOwnProperty(name)) {
            attrs[name] = set[name];
        }
    })
    return attrs;
}


var _pickAttrs_v2d = function(set, allow, rules){
    var attrs = {};
    _.each(attrs, function(value, name){
        if (_.includes(allow, name)) {
            attrs[name] = set[name];
        }
        //дополнительно: если передана функция, выполняем её
        if (rules) {
            var res = rules(name, set[name], attrs, allow)
            if (res) attrs = res;
        }
    });
    return attrs;
}


const _delay = function(time, body, thisArg){
    //return setTimeout(body.bind(thisArg || null), time)

    return setTimeout(function(){
        body.call(thisArg || null)
    }, time)
}

<? include $js['utils/time']; ?>

<? include $js['utils/set']; ?>

<? include $js['utils/lodash']; ?>

