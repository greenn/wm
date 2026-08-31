<?#5.2.1
/*
    https://api.jquery.com/jquery.ajax/
    https://slyweb.ru/jquerydoc/jQuery-ajax-options.php

    _error = rb/vue/env-js/api.js.inc:50
    _fail = rb/vue/env-js/api.js.inc:25
*/?>
_log.set_({
    //'api-jquery|0': !1,
    'jq': !1,
    'jq/success': 1,
});

api_request = function(method, uriApi, data, cb, opt, extra){
    //_log('api-jquery|0', { method, uriApi, data, cb, opt })
    //if (!opt) opt = true;
    if (!cb) cb = {};
    if (!opt) opt = {};

    if (typeof cb == 'function') {
        cb = { success: cb }
        if (opt === true || opt.oneHandler) cb.error = cb.success; //case: Одна функция на success и error
    }
    if (typeof opt == 'function') {
        cb.error = opt;
        opt = extra || {};
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



    if(0) _log('api-jquery/options', {
        method, uriApi, data, cb, opt, extra
    })

    var runFallback = true;
    var finallyHandler = function(){
        //if (opt.dbg) _log('api-jquery/finallyHandler0', { arguments });
        var args = arguments;
        afterDelay(function(){
            opt.busy && opt.busy(false); //unset-busy

            //_log('fin', { cb_after: cb.after, cb, args })
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

        complete: function(xhr) {
            if (0) {
                const contentType = xhr.getResponseHeader('Content-Type');
                _log('complete', { contentType, isJosn: contentType.includes('application/json') })
                if(0) if (!contentType || !contentType.includes('application/json')) {
                    console.warn('Сервер вернул не JSON:', contentType);
                }
            }
        },

        success: function(response){
            //_log('api-jquery/success0', { arguments });
            if (opt.dbg) _log('api-jquery/success0', { arguments });

            afterDelay(function(){


                var parsedOk;
                try {
                     parsedOk = typeof response === 'object' ? response : JSON.parse(response);
                } catch (e) {
                    //_log('api-jquery / catched-parsed-response', { response, e });

                    ///else _log('api-jquery /  Ошибка в Ajax-ответе / и не задан error-handler', { response });
                    var runFallback = cb.error && cb.error(response, data);
                    if (runFallback !== false) {
                        //alert('ошибка-2');
                        _errorHandler(response);
                    }

                }


                if (parsedOk) {
                    //_log('jq/success', { response, 'delay-args': arguments });

                    if (opt.dbg) _log('jq/dbg', {
                        response,
                        arguments: { method, uriApi, data, cb, opt, extra },
                        isSuccess: [((response && !response.error) || opt.forceSuccess), '~', response && !response.error, '|', opt.forceSuccess]
                    });

                    if ((response && !response.error) || opt.forceSuccess) {
                        //alert('ok-1');
                        _successHandler(cb.success, response, data, method, uriApi);
                        //if (cb.success) cb.success(response, data)
                    } else {
                        //есть обший fallbackHandler, его  можно не вызывать вернув false в cb.error
                        if (opt.oneHandler) {
                            var runFallback = cb.error && cb.error(response, data)
                            if (runFallback !== false) {
                                //alert('ошибка-2');
                                _errorHandler(response);
                            }
                        }
                    }
                }
            });
        },

        error: function(re){
            var args = arguments;
            _log('fail-0');
            //_log('api-jquery/error', { arguments, response: re.responseText,  oneHandler: opt.oneHandler, errorHandler: cb.error });
            //alert('ошибка-3');
            afterDelay(function(){
                _log('fail-01');
                if (opt.oneHandler) {
                    //_log('fail-3');
                    var runFallback = cb.error && cb.error(re.responseText, data)
                    finallyHandler();
                    if (runFallback !== false) {
                        //alert('ошибка-2');
                        _errorHandler(re);
                    }

                } else if (cb.error) {
                    //_log('fail-2');
                    var runFallback = cb.error && cb.error(re.responseText, data)
                    finallyHandler();
                    if (runFallback !== false) {
                        //alert('ошибка-2');
                        _errorHandler(re);
                    }
                } else {
                    //_log('fail-1');
                    if (cb.fail) {
                        //alert('ошибка-4');
                        cb.fail(re)
                    }
                }


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

if(!1) $(document).ajaxSend(function(event, jqXHR, settings) {
    _log("AJAX SETTINGS", { settings });
});