
__self.pick = function(baseName, prop){
    //console.log(`DBG: ${prop} in ${baseName}`);
    var res = {};
    _.each(_list, function(r, name){
        //_log('pick/match', [name, baseName, _.startsWith(name, baseName)]);
        if (_.startsWith(name, baseName)) {
            res[name] = prop ? _cc(r[prop]) : _cc(r)
        }
    })
    return res;
}

__self.ccall = function(...args){
    var result = __self.apply(null, args);
    return _cc(result);
}