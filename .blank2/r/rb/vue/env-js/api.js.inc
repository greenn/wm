<?#2.3.0 ?>
<? $js; ?>

const $delay = function(duration){
    var $process = $.Deferred();
    //console.time('api-delay');
    setTimeout(function(){
        $process.resolve({ duration })
        //console.timeEnd('api-delay')
    }, duration);
    return $process;
}

const WebApi = function(cfg){
    //_self = {};
    if (!cfg) cfg = {};

    var defFallback = cfg.fallback || function(ctx){
        emittery.emit('system-error', ctx);
    }
    if (!cfg.onError) cfg.onError = defFallback;
    if (!cfg.onFail) cfg.onFail = defFallback;



    var _log = Log.for(cfg.log || 'API');


    var api_delay = cfg.delay || 0;
    var next_delay = [];
    var set_next_delay = function(val){
        next_delay.push(val);
    };
    var verify_prev_delay = function(){
        if (next_delay.length) {
            api_delay = next_delay.pop();
        }
    };

    var baseUri = cfg.baseUri || '/api'; //'<?//=rt('api', 'apiUrl')?>'
    var baseEmuUri = cfg.baseEmuUri || (function(){
        var chunks = baseUri.split('/');
        chunks.splice(2, 0, '%method');
        return chunks.join('/');
    })();


    //var api_request = async function(method, uriApi, data, cb){}; //finally
    var api_request = function(method, uriApi, data, cb){};


	<? include $js['api/jquery'] // api_request - rb/vue/env-js/api/api-jquery.js.inc?>


    api_request.get = api_request.bind(null, 'get');
    api_request.post = api_request.bind(null, 'post');
    api_request.put = api_request.bind(null, 'put');
    api_request.delete = api_request.bind(null, 'delete');
    api_request.patch = api_request.bind(null, 'patch');
        //https://stackoverflow.com/questions/38945677/using-jquery-patch-to-make-partial-update


    var _successHandler = cfg.successHandler || function(cb, response, data){
        if (cb) {
            cb(response, data)
        }
    }

    var _failHandler = function(ajax, cb){
        cfg.onFail({
            title: 'Ошибка AJAX',
            msg: 'Повреждённый ответ', //Нет оzтвета
            ctx: { ajax: ajax }
        })
    }

    var _errorHandler = function(response){
        _log('_errorHandler', { response })
        var title = 'Ошибка'; //'Ошибка API'
        var msg = response.error || 'Error';
        if (msg === true) {
            msg = response.message || response.msg || 'API Error'
        }
        if (response.status) {
            msg = response.status + ': ' + msg;
        }
        if (response.sql_error) {
            title = 'SQL Ошибка'
            msg = response.sql_error
        }

        //#C5
        if (response.errors) {
            var error = response.errors[0];
            msg = error.msg;
            title = title.msg;
        }

        //_log('_error', { 'system-error': ctx });
        cfg.onError({
            title: title,
            msg: msg,
            ctx: response
        });
    }


    var dbSuffix = '_fk1';
	<? //include $js['db-data'] ?> //DbData
    <? //include $js['db-api'] ?> //DbApi
        /*
            Api.clients.getAll(function(response){
                console.log('DBAPI', 'clients/getAll', response)
            })
        */

	<? include $js['api/made'] //api_made(), api_take() ?>


    //_self =
    return _.extend({
        delay: function(val){
            if (!arguments.length) return api_delay;
            api_delay = val;
        },

        //выставить задержку для (одного) следующего запроса
        //и после вернуть текущей значение
        delay_next: set_next_delay,

        setOpt: function(optName, optValue){
            if (arguments.length === 1) optValue = true;
            return apiOpt[optName] = optValue;
        },

        request: api_request,
        get: api_request.get,
        post: api_request.post,
        put: api_request.put,
        delete: api_request.delete,
        patch: api_request.patch,

        made: api_made,
        take: api_take,

        //db_rebuild: db_rebuild,
        //db_verify: db_verify,

        uri: function(uri, query){
            var url = [baseUri, uri].join('/');
            if (query) {
                url += '?' + $.param(query);
            }
            return url;
        },

        <?/*
            -   -   eg
                Api.assignArray({
                    api: 'metro/targets/list',
                    responseProp: 'list',
                    self: this,
                    resProp: 'items',
                });
        */?>
        //сниппет добавления данных из ответа в массив
        assignArray: function(set){ //2.1 [ff: ,cb, opt]
            var _Api = this;
            set = _.defaults(set, {
                method: 'get',
                data: {},
                responseDef: true, //данные приходят в свойстве .data
                responseProp: 'list',
                //this: null,
                resProp: 'list',
                busy: true,
                //res: {},
                instantly: true, //присваивание данных сразу
            })
            //if (!set.resProp) set.resProp = set.responseProp;

            if (set.data) set.data.tmp = moment().unix();

            var setBusy = _madeBusy(set);


            setBusy(true);
            _Api.request[set.method](set.api, set.data, {
                success: function(response, request, realResponse){
                    var toFetchData = set.cb && set.cb(response);
                    if (toFetchData === false) return;

                    var responseCtx;

                    if (cfg.responseAsData) responseCtx = set.responseDef === false ? realResponse : response;
                    else responseCtx = set.responseDef ? response.data : response;
                    //_log('assignArray', { 'cfg.responseAsData': cfg.responseAsData, responseCtx, response })

                    var responseData = _.get(responseCtx, set.responseProp);
                    //_log('assignArray', { responseData, responseCtx, responseProp: set.responseProp })

                    if (set.dbg) _log('assignArray("' + set.api + '")/response', { set, response, responseData });
                    //_log('assignArray', { 'set.instantly': set.instantly, 'set.resProp': set.resProp, value: responseData, 'set.this': _cc(set.this.$data) })

                    if (set.instantly) {
                        if (set.this) {
                            set.this[set.resProp] = responseData;
                        } else {
                            if (_.isArray(set.res) && (set.res.length === 2)) {
                                var _this = set.res[0];
                                var _prop = set.res[1];
                                _this[_prop] = responseData;
                            } else {
                                set.res = responseData;
                            }

                        }
                    } else {
                        _.each(responseData, function(item, key) {
                            if (set.this) {
                                set.this[set.resProp][key] = item;
                            } else {
                                if (_.isArray(set.res) && (set.res.length === 2)) {
                                    var _this = set.res[0];
                                    var _prop = set.res[1];
                                    _this[_prop][key] = item;
                                } else {
                                    set.res[key] = item;
                                }

                            }
                        });
                    }

                    if (set.this) {
                        set.cbRes && set.cbRes.call(set.this, responseData, response);
                    } else {
                        set.cbRes && set.cbRes(responseData, response);
                    }

                    setBusy(false);
                },
                after: function(){
                    setBusy(false);
                }

            })

        },

        assignData: function(set){
            var _Api = this;
            set = _.defaults(set, {
                method: 'get',
                data: {},
                responseProp: 'item',
                //this: null,
                resProp: 'item',
                res: {},
                busy: true,
                instantly: true,
            })
            //if (!set.resProp) set.resProp = set.responseProp;

            if (set.data) set.data.tmp = moment().unix();

            var setBusy = _madeBusy(set);

            setBusy(true);
            _Api.request[set.method](set.api, set.data, {
                success: function(response){
                    var toFetchData = set.cb && set.cb(response);
                    if (toFetchData === false) return;

                    var responseData = _.get(response, set.responseProp);
                    if (set.dbg) _log('assignData/api/data', {
                        set, response, responseData,
                        'case1': set.this && set.this[set.resProp],
                    });

                    if (set.instantly) {
                        if (set.this) {
                            set.this[set.resProp] = responseData;
                        } else {
                            if (_.isArray(set.res) && (set.res.length === 2)) {
                                var _this = set.res[0];
                                var _prop = set.res[1];
                                _this[_prop] = responseData;
                            } else {
                                set.res = responseData;
                            }
                        }
                    } else {
                        _.each(responseData, function(value, prop) {
                            if (set.this) {
                                if (!set.this[set.resProp]) {
                                    set.this[set.resProp] = {};
                                }
                                set.this[set.resProp][prop] = value;
                            } else {
                                if (_.isArray(set.res) && (set.res.length === 2)) {
                                    var _this = set.res[0];
                                    var _prop = set.res[1];
                                    _this[_prop][prop] = value;
                                } else {
                                    set.res[prop] = value;
                                }
                            }
                        });
                    }

                    set.cbRes && set.cbRes(responseData, response); //01
                    setBusy(false);
                },
                after: function(){
                    setBusy(false);
                }
            })

        }


    }, typeof DbApi !== 'undefined' ? DbApi : {})


};





api = function(method, ctx){
    return api[method](ctx)
}

//async_api
api_ = async function (method/*, arg1, argN*/){
    var args = Array.prototype.slice.call(arguments, 1);
    return new Promise(function(resolve, reject){
        //console.log('api_', { method, args, 'api[method]': api[method] })
        args.push(resolve, reject)
        api[method].apply(null, args);
    })

}



/*
api = (function(){
    var cache = {};
    var api = function(name, method, ctx){
        var _api = Api.take(name);
        if (_api) {
            return _api[method](ctx);
        } else {
            //Log.error();
            console.warn(`Api ${name} отсутсвует`);
        }
    };

    return api;
})();
*/
