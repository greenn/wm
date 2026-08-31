<?/*
*/?>
_log.set_({
    'api_made': 0
});

var ApiCache = {};
api_take = function(apiName){
    return ApiCache[apiName];
};

var ApiMethods = {}
api_made = function(cfg){

    var _api = {


    };

    if (typeof cfg === 'function') {
        cfg = cfg();
    }

    _log('api_made', { cfg })

    _.each(cfg, function(set, method){

        //_api[method] =
    })

    return _api;
};