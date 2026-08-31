var useAxios = false; //true, 'json'
<? if (0) { ?>
if (useAxios && window.axios) {
	<?/*
            нюанс в том, что axios шлёт строго json на сервер
            и требует спец. обработки либо на сервере, либо во время отправки
            dd
        */?>
	<? //include $js['api/axios'] // api_request ?>
    api_request = function(){}
}
<? } ?>


<?/*
    https://github.com/axios/axios#creating-an-instance

*/?>
axios.defaults.baseURL = startUri;
//[04] axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded'; //#[json-mod]
api_request = function(method, uriApi, data, success_cb, error_cb, fail_cb){

    var cfg = {
        //baseURL: <?=''?>,
        url: uriApi,
        method: method
        /* more:
            responseType: 'stream'
        */
    }

    if (method == 'get') {
        cfg.params = data;
    } else {
        cfg.data = data;
    }

    if (useAxios !== 'json') {
        cfg.headers = { 'content-type': 'application/x-www-form-urlencoded' };
        cfg.data = Qs.stringify(cfg.data);
    }

    //_log('axios', { axios, cfg });
<? if (0) { ?>

    const instance = axios.create({
        baseURL: 'https://some-domain.com/api/',
        timeout: 1000,
        headers: {'X-Custom-Header': 'foobar'}
    });
<? } ?>

    return axios(cfg);

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
