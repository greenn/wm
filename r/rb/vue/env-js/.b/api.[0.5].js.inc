<?#0.5.43?>
const Api = (function(){
    var _log = Log.for('API');
    axios.defaults.baseURL = '/api/'; //'<?=rt('api', 'apiUrl')?>'
    //axios.defaults.headers.post['Content-Type'] = 'application/json'; //#[json-mod]
    axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded'; //#[json-mod]
    //alert(11);
    var loginData = Store.get('loginData') || {};
    var apiOpt = {
        rawResponse: false,
        cache: false,
    };

    var _crash = function(error){
        emittery.emit('system-error', {
            title: 'crash: API error',
            msg: error,
        });
    }

    var _fail = function(ajax, cb){
        var ctx = {
            title: 'fail: ответ API',
            msg: 'нет ответа',
            ctx: ajax
        };
        var extend = cb && cb(ajax);
        if (extend) _.extend(ctx, extend);

        emittery.emit('system-error', ctx);
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

        emittery.emit('system-error', ctx);
    }

    var _error = function(response, cb){
        var ctx = {
            title: 'error: ошибка из API',
            ctx: {
                response: response
            }
        };


        var extend = cb && cb(ajax);
        console.log('api|api-error|extend', { extend: extend, cb: cb });
        if (!extend) {

            var msg = response.error;
            if (msg === true) {
                msg = response.message
            }
            if (response.status) {
                msg = response.status + ': ' + msg;
            }
            extend = {
                msg:  msg
            }
        }
        _.extend(ctx, extend);



        emittery.emit('system-error', ctx);
    }

    //ak post
    const api = function(uri, data, success_cb, error_cb, fail_cb){
        //console.log('api/post', [uri, data]);
        _log('api', { axios });

        return axios.post(uri, data)
            .then(function(ajax){
                console.log('api/response', {
                    api: uri,
                    post: data,
                    //'post.json': JSON.stringify(data, null, 4), #[json-mod]
                    'api-options': apiOpt,
                    axios: ajax,
                    response: ajax.data
                });
                var response = ajax.data;
                if (!response) {
                    //case: fail
                    _fail(ajax, fail_cb);
                } else if (response.error) {
                    //case: error-data
                    _error(response, error_cb);
                } else if (response.curlJsonError) {
                    _badResponse(response.curlJsonError, response);
                } else {
                    //case: success
                    if (success_cb) success_cb(response)
                }
            })
            /*
            .catch(function (error) {
                //console.warn('api-catch', { uri: uri, data: data, error: error, args: arguments });
                console.warn('api-crash', [error.fileName, error.lineNumber, error.columnNumber]);
                _crash(error.message)
            });
            */
        ;
    };

    //ak acc_post
    const acc_api = function(uri, data, success_cb){
        _.each(apiOpt, function(val, name){
            if (val) data[name] = true;
        });

        return api(uri, data, success_cb)
    }

    var dbSuffix = '_fk1';
	<? include $js['db-data'] ?> //DbData
    if (true) db_verify();
	<? include $js['db-api'] ?> //DbApi

    return _.extend({
        setOpt: function(optName, optValue){
            if (arguments.length === 1) optValue = true;
            return apiOpt[optName] = optValue;
        },

        request: api,

        db_rebuild: db_rebuild,
        db_verify: db_verify,
    }, DbApi)

    /*
Api.clients.getAll(function(response){
    console.log('DBAPI', 'clients/getAll', response)
})
    */
})();

api = (function(){
    var api = function(){};

    return api;
})();