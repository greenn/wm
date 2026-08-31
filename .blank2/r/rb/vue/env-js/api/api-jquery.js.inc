<?#5.2.1
/*
    https://api.jquery.com/jquery.ajax/
    https://slyweb.ru/jquerydoc/jQuery-ajax-options.php

    _error = rb/vue/env-js/api.js.inc:50
    _fail = rb/vue/env-js/api.js.inc:25
*/?>
_log.set_({
    'api-jquery|0': 1,
    'jq': !!1,
    'jq/success': !1,
});

api_request = function(method, uriApi, data, cb, opt){
    //_log('api-jquery|0', { method, uriApi, data, cb, opt })
    //if (!opt) opt = true;
    if (!cb) cb = {};
    if (!opt) opt = {};

    if (typeof cb == 'function') {
        cb = { success: cb }
        if (opt === true) cb.error = cb.success; //case: Одна функция на success и error
    }
    if (typeof opt == 'function') {
        cb.error = opt;
    }

    if (_.isArray(cb)) {
        var cb_map = ['success', 'error', 'after', 'fail']
        cb = _.transform(cb, function(res, fn, idx){
            var cb_name = cb_map[idx] || idx;
            res[cb_name] = fn
        }, {})
    }


    if (opt.busy) {
        if (_.isArray(opt.busy)) {
            var optBusy = opt.busy;
            var busySelf = optBusy[0];
            var busyProp = optBusy[1];
            opt.busy = function(state){
                _.set(busySelf, busyProp, state);
            }
        }
        if (typeof opt.busy !== 'function') {
            opt.busy = false
        }
        if (typeof opt.busy === 'function') {
            //всё ок
        }
    }




    var runFallback = true;
    var finallyHandler = function(){
        var args = arguments;
        afterDelay(function(){
            opt.busy && opt.busy(false); //unset-busy

            //_log('after', { cb_after: cb.after, cb, args })
            cb.after && cb.after()
            verify_prev_delay();
        })
    }

    //запускаем задержку до ajax
    var $delayReady = $delay(api_delay);
    var $customDelay = opt.delay ? $delay(opt.delay) : false;
    var afterDelay = function(body){
        //$delayReady.then(body)
        $.when($delayReady, $customDelay).then(body)
    }

    var url = [baseUri];
    if (opt.emu) {
        url = [baseEmuUri.replace('%method', method)]
        method = 'get';
    }

    typeof uriApi == 'string' ? url.push(uriApi) : url = url.concat(uriApi);
    url = url.join('/');
    var cfg = {
        url: url,
        type: method,
        data: data,

        ...(opt.ajax || {}),

        xhrFields: {
            withCredentials: true, //crossdomain передача кукисов (для сессий)
            //responseType: 'json',
        },

        success: function(response){
            afterDelay(function(){
                _log('jq/success', { response, 'delay-args': arguments });
                if ((response && !response.error) || opt.forceSuccess) {
                    _successHandler(cb.success, response, data, method, uriApi);
                    //if (cb.success) cb.success(response, data)
                } else {
                    if (cb.error) {
                        runFallback = cb.error(response, data)
                    }
                    //есть обший fallbackHandler, его  можно не вызывать вернув false в cb.error
                    if (runFallback) _errorHandler(response);
                }
            });
        },

        error: function(re){
            afterDelay(function(){
                if (cb.fail) {
                    runFallback = cb.fail(re)
                }
                if (runFallback) _errorHandler({ ajax: re });
            })
        },

        //after: finallyHandler, //always|after|fine

        /*

        url: a_cross_domain_url,
        xhrFields: {
            withCredentials: true
        }

        contentType: 'application/json;charset=UTF-8';
        processData: 

        async: false, // must be synchronous to guarantee that no tests are run before fixture is loaded

        cache: false,

        dataType: 'json',

        converters: {
            "* text": window.String,
            "text html": true,
            "text json": jQuery.parseJSON,
            "text xml": function(data){return data.toUpperCase()}
        },
        */

    }



    //dbg
    //debugger;
    if (0 && 'замена formData просто на data') {
        if ((cfg.data instanceof FormData && cfg.data.entries)) {
            /*
                ajax: {
                    enctype: 'multipart/form-data',
                    processData: false,  // Important!
                    contentType: false,
                    cache: false,
                    dataType: 'json', //для ответа
                }
            */

            //https://stackoverflow.com/questions/18606305/accessing-formdata-values#answer-42716102
            var formData = cfg.data.entries();
            var obj = formData.next();
            var retrieved = {};
            while(undefined !== obj.value) {
                retrieved[obj.value[0]] = obj.value[1];
                obj = formData.next();
            }
            //cfg.formData = retrieved; //q formData
            cfg.data = retrieved;
        }
    }

    _log('jq', { url, cfg }, { method, uriApi, data, cb, opt });

    opt.busy && opt.busy(true); //set-busy
    return $.ajax(cfg).then(finallyHandler)
    //return $.when($.ajax(cfg), $delay(api_delay)).always(verify_prev_delay)
};