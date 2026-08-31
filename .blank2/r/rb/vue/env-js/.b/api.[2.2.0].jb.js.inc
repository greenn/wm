if (!cfg.onCrash) cfg.onCrash = defFallback;
if (!cfg.onBadResponse) cfg.onBadResponse = defFallback;


var _fail = function(ajax, cb){
    var ctx = {
        title: 'fail: ответ API',
        msg: 'нет ответа',
        ctx: ajax
    };
    var extend = cb && cb(ajax);
    if (extend) _.extend(ctx, extend);

    cfg.onFail(ctx)
}

var _error = function(response, cb){
    var ctx = {
        title: 'error: ошибка из API',
        ctx: {
            response: response
        }
    };

    var extend = cb && cb(ajax);
    //_log('_error|extend', { extend, cb, ctx });
    if (!extend) {

        var msg = response.error;
        if (msg === true) {
            msg = response.message || response.msg
        }
        if (response.status) {
            msg = response.status + ': ' + msg;
        }
        extend = {
            msg: msg || 'Ошибка'
        }
    }
    _.extend(ctx, extend);

    //_log('_error', { 'system-error': ctx });
    cfg.onError(ctx);
}


    var _crash = function(error){
        cfg.onCrash({
            title: 'crash: API error',
            msg: error,
        })
    }

    var _badResponse = function(curlJsonError, response){
        var ctx = {
            title: 'fail: API bad response',
            msg: 'JSON: ' + curlJsonError[1],
            ctx: {
                raw: response.curlResponse,
                curl: response.curlStatus,
            }
        };
        cfg.onBadResponse(ctx);
    }


api_request = function(method, uriApi, data, cb, opt){
    //_log('api-jquery|0', { method, uriApi, data, cb, opt })
    if (!opt) opt = true;

    if (!cb) cb = {};
    if (typeof cb == 'function') {
        var _cb = cb;
        cb = { success: cb }
        if (opt === true) cb.error = _cb; //case: Одна функция на success и error
    }



    if (!cb.fail) cb.fail = _fail;
    if (!cb.error) cb.error = _error;