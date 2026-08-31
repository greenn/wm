<?#5.16

//_needphp('r');

include PHP.'/api/api.class.php';

/*
    get
        Извлечь
    post
        Создать
    put
        Обновить
    delete
        Удалить
*/
function api_default($ctx = null, $opts = null){
    static $api = null;
    if (func_num_args()) {
        $api = new API($ctx, $opts);
    }
    return $api;
}

//function api_config(){}


function api($method = 'get', $path = '', $data = true, $apiInst = true, $apiOpts = null, $apiCtx = null) {
    $response = null;

    $api = null;
    if ($apiInst === true) $api = api_default();
    elseif ($apiInst instanceof API) $api = $apiInst;
    elseif ($apiInst) $api = new API($apiInst, $apiOpts);

    if ($api instanceof API) {
        if ($apiCtx) $api->setCtx($apiCtx);
        if ($apiOpts) $api->setOpts($apiOpts);
        $api->run($method, $path, $data);
        $response = $api->responseData();
    }

    return $response;
}


/*
    https://uncaughtexception.ru/2017/05/15/kak-razrabotat-praktichnyy-rest-api.html
    https://habrahabr.ru/post/144011/

get
    Извлечь
post
    Создать
put
    Обновить
        Спецификация HTTP 1.1 гласит, что PUT идемпотентен.
            Это значит, что клиент может выполнить множество PUT запросов по одному URI и это не приведет к созданию записей дубликатов.
patch
    Частично обновить
delete
    Удалить

*/