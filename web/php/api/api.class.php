<?#5.4.0

_needphp('dataPath');
_needphp('isAssoc');

define('API_DEBUG', true);

x('apiDebugOpts', array(
    'tokenResponse' => 0,
    'justResponse' => 0,
    'fullResponse' => 1,
    'responseRequest' => 1,
    'responseRequestData' => 1,
    'responseInfo' => 1,
    'responseToken' => 1,
));

class API { //API_RESPONSE|API_REQUEST
    var $prettyOutput = true;
    var $cache = null;

    var $portableOptions = array(
        'uri', 'dir', 'pathStart',

        'path', 'emuRest', 'method', 'data',

        'config', 'configPath', 'configSubPath'
    );

    var $set = array( //[rn] opts
        //'responseType' => 'full', //'full', 'raw', 'token',

        'replyType' => 'json', //'json', 'plain'
        'CORS' => false,

        'tokenResponse' => 0,
        'justResponse' => 0,
        'fullResponse' => 1,
            'responseRequest' => 0,
            'responseRequestData' => 0,
            'responseInfo' => 0,
            'responseToken' => 0,

        'cacheVerify' => 0
    );
    var $ctx; //keep original context
    var $dirPath;
    var $pathStart = '';

    var $uri;
    var $method;
    var $emuRest;
    var $data;
    var $path;
    //var $subPath;
    var $pathPage; //~ [ph не вычисляюст и не используются]
    var $pathDir; //~ [ph не вычисляюст и не используются]
    var $tokenStart;
    var $tokenPath;
    var $tokenPage;
    var $tokenPageSeq; //продолжение страницы

    var $config; //
    var $configPath; //
    var $configSubPath; //
    var $tokens = false; //tokens|handlers|routes|
    var $handlerPatterns = null;

    var $hasResponse = false;
    var $token = null;
    var $request = array();
    var $response = array();
    var $info = array('handler' => array());
    var $errors = array();

    function __construct($ctx = null, $opts = null) {
        if (is_array($opts)) {
            $this->setOpts($opts);
        }

        if (is_array($ctx)) {
            $this->setCtx($ctx);
        }
    }

    public function setOpt($name, $val = 1){
        $this->set[$name] = $val;
    }
    public function setOpts($opts/*, val of first-arg-as-name*/){
        if (is_string($opts)) {
            $opts = make_arr($opts, func_num_args() == 2 ? func_get_arg(1) : 1); //[to]
        }

        $this->set = array_replace($this->set, $opts);
    }
    public function set($opt){ //[rn] opt
        return prop($this->set, $opt, null);
    }

    private function getConfig($path){
        $ctx = inc($path, INC_RES_AS_ARRAY);
        return $ctx;
    }

    public function setCtx($ctx){
        if (is_string($ctx)) {
            $ctx = $this->getConfig($ctx);
        }

        $this->ctx = $ctx;
        foreach ($ctx as $opt => $value) {
            if (property_exists($this, $opt)) {
                $this->{$opt} = $value;
            }
        }

        $this->handleConfig();
    }

    private function handleCtx(){}

    private function handleConfig(){
        $confPath = null;
        if ($this->configSubPath) {
            //dx($this->configSubPath);
            $confPath = $this->dirPath.'/'.$this->configSubPath;
        }
        if ($this->configPath) {
            //dx($this->configSubPath);
            $confPath = $this->configPath;
        }

        if ($confPath && realpath($confPath)) {
            $this->config = inc($confPath, INC_RES_AS_ARRAY);
            unset($this->configSubPath);
            unset($this->configPath);
        }

        //dx($this->config, $confPath, realpath($confPath));
        if ($this->config) {
            if ($tokens = prop($this->config, 'tokens')) $this->tokens = $tokens;
            if ($patterns = prop($this->config, 'handlerPatterns')) $this->handlerPatterns = $patterns;
        }
    }

    static function methodData($methodType, $emuRest = false){
        $_DATA = null;
        if ($emuRest) {
            $_DATA = $_GET;
        } else switch ($methodType){
            case 'get':
                $_DATA = $_GET;
                break;
            case 'post':
                $_DATA = $_POST;
                break;
            case 'put': case 'patch': case 'delete':
                parse_str(file_get_contents('php://input'), $_DATA);
                break;
            //case 'sys': break; вариант для только системного обращения
        }
        return $_DATA;
    }

    private function handleRequest(){

    	//dx($this->tokenExist());

        if ($token = $this->tokenExist()) {
            $this->token = $token;
            //dx($token, $this->tokenAccess($token), $this->tokenHandler($token));
            if ($this->tokenAccess($token) || 'full-access-in-beta') {
                if ($handler = $this->tokenHandler($token)) {
                    //dx($token, $this->set('cacheVerify'));
                    if ($this->set('cacheVerify')) {
                        $this->tokenCacheVerify($handler);
                    }

                    $this->tokenApply($handler);
                    //$this->token = array();
                }
            } else { //case: no access
                $this->error(array(
                    'type' => 'http',
                    'http' => '403',
                    'msg' => '403 Forbidden',
                ));
            }
        }

    }

    private function tokenLookForMatch($path = null) {
        $token = null;
        if (func_num_args()) {
            //если передан аргумент $path, то ищем в своих токенах совпадение
            $token = prop($this->tokens, $path);
        } else {
            //dx($this->tokens, $this->path, $this->tokens);
            $path = $this->path;
            $token = $this->tokenLookForMatch($path);
            //if (!$token) $token = $this->tokenLookForMatch($this->pathDir);
            if (!$token) {
                //убираем токен с конца до совпдения или конца строки
                while(!$token && $path) {
                    $path = preg_replace("~/?[^/]*$~", '', $path);
                    $token = $this->tokenLookForMatch($path);
                };
                //dx($path, $token);
            }
        }
        if ($token) {
            $this->handlePath($this->path, $path);
        }
        return $token;
    }

    //нетолько проверка но и получение токена: getTokenIfExist
    private function tokenExist() {
        $token = $this->tokenLookForMatch();
        //dx($this->method, $token, $this->tokens, $this->path, $this->pathDir, $this->pathPage);
        $tokenMethod = prop($token, $this->method, null);
        if ($tokenMethod) {
            if (isOrdinal($tokenMethod)) $tokenMethod = merge_keys_values(array('handlerPath', 'uu', 'etag', 'handlerReturn'), $tokenMethod, true, false, array(1 => true));
            elseif (is_string($tokenMethod)) $tokenMethod = array('handlerPath' => $tokenMethod, 'uu' => true);
            elseif (!is_array($tokenMethod)) $tokenMethod = array(); //case: true \ для false не учитывается [mzd]
            $tokenMethod = array_replace($token, $tokenMethod);
        }
        //dx($tokenMethod, $token);
        return $tokenMethod;
    }

    private function tokenAccess($token) {
        $uuAccess = prop($token, 'uu');
        $tokenAccess = $uuAccess || ua(); //$this->ua() $this->sol_ua() $this::uaCaller
        //dx($token, $uuAccess, ua());
        return $tokenAccess;
    }

    private function tokenHandler($token) {
        $handlerPath = prop($token, 'handlerPath');
        //dx($token, $handlerPath, realpath($handlerPath));

        if (!$handlerPath) {
            //  script-1: api0, dir0
            $handlerType = prop($token, 'handlerType', 'def');
            $patternConf = prop($this->handlerPatterns, $handlerType);
            //dx($handlerType, $patternConf);

            //$nameProp = prop($patternConf, 'prop');


            $pathPattern = prop($patternConf, 'path');
            if (!$pathPattern) $pathPattern = $this->dirPath.'/'.prop($patternConf, 'relPath');

            $pathArgs = prop($patternConf, 'args');

            //$handlerName = prop($token, $nameProp);
            //$this->token['handler'] = $handlerName;

            $patternOptions = array($pathPattern);
            foreach ($pathArgs as $dataPath) {
                if (!is_array($dataPath)) $dataPath = array($dataPath);
                $val = dataPath($dataPath, $this);
                $patternOptions []= $val;
            }
            $handlerPath = call_user_func_array('sprintf', $patternOptions);
            //dx($handlerPath, is_file($handlerPath));
            //  --

            //$handlerPath = sprintf($pathPattern, $handlerName, $this->method);
        }


        return realpath($handlerPath) ? $handlerPath : null;
    }

    private function tokenHandle($handlerPath){
        $token = $this->token;
        x('apiHandlerPar', $this);
	    if (!is_null_or_false($handlerReturn = prop($token, 'handlerReturn'))) {
            $result = inc($handlerPath, is_integer($handlerReturn) ? $handlerReturn : INC_RES_AS_DATA);
            //dx($result);
        } else {
            //INC_RES_AS_IS
            x('apiHandlerResult', null);
            include $handlerPath;
            $result = x('apiHandlerResult');
        }

        xd('apiHandlerPar');
        return $result;
    }

    private function tokenCacheVerify($handler) { //etag verify
        $token = $this->token;
        //dx($handler, $token);
        if (prop($token, 'etag')) {
            x('apiCacheVerify', true); //apiEtagVerify
            $result = $this->tokenHandle($handler);
            xd('apiCacheVerify');

            /*dx(
                $result,
                etag::byCtx($result, false),
                Headers::is304($result),
                headers_obj($result)->stack, headers_obj($result)->prepare_output(),
                Headers::parseOption('304')
            );*/

            if ($headers = Headers::is304($result)) {
                $headers->apply();
            } else {
                $this->cache = $result;
            }
        }
    }

    private function tokenApply($handlerPath) {
        //dx($handlerPath);

        $result = $this->tokenHandle($handlerPath);
        //if ($result instanceof apiTokenResponse){} //apiTokenResponseState

        $this->hasResponse = true;

        $token = $this->token;
        if ($propName = prop($token, 'resProp')) {
            $this->response[$propName] = $result;
            $this->info['handler'][$this->token['name']]['prop'] = $propName;
        } else {
            //dx(11, $result);
            $this->response = $result;
        }

        if ($tokenOpts = prop($token, 'opts')) {
            $this->setOpts($tokenOpts);
        } else {
            $this->setOpts(array('tokenResponse' => true));
        }
    }



    //public function addResponse($data, $info){}
    //public function addResponseProp($propName, $propData, $propState){}
    //public function tokenResponse($data, $propName, $tokenState){}

    public function getRequest($data = false){
        $request = array(
            'web' => array(
                'pageName' => pageName,
                'pageUri' => pageUri,
                'pagePath' => pagePath,
                'pageQuery' => pageQuery,
            ),
            'api' => array(
                'apiPath' => $this->path,
                'apiToken' => $this->tokenStart,
                'apiPage' => $this->tokenPage,
                'apiSubPath' => $this->tokenPath,
                'apiMethod' => $this->method,
                'emuRest' => $this->emuRest,
            )
        );

        if ($data || $this->set('responseRequestData')) {
            $request['data'] = $this->data;
        }

        return $request;
    }

    private function lookForDebugOpts(){
        foreach ($_GET as $opt => $value) {
            if (isset($this->set[$opt])) {
                $this->set[$opt] = $value;
                if ($opt === 'fullResponse') {
                    $this->set['justResponse'] = 0;
                    $this->set['tokenResponse'] = 0;
                }
            }
        }
        //dx($_GET, $this->set);
    }

    public function error($msg = 'Ошибка', $ctx = null){
    	if (func_num_args() === 1 && is_array($msg)) { //L
		    $msg = 'Ошибка';
		    $ctx = func_get_arg(0);
	    }
	    $error = array('msg' => $msg);
    	if ($ctx) {
		    $error['ctx'] = $ctx ;
	    }
        $this->errors []= $error;
    }

    static function makeMultiData($data, $scheme = true){
        $res = false;

        if (isOrdinal($data) && ($n = count($data))) {
            if ($n === 1) {
                $res = $data[0];
                if ($scheme === true) {
                    if (is_string($res)) {
                        $res = array('msg' => $res);
                    }
                }
            } else {
                $res = array(
                    'items' => $data,
                    'type' => 'multi',
                );
            }
        }

        return $res;
    }

    public function errorData(){
        return static::makeMultiData($this->errors);
    }

    public function responseData(){
        $this->lookForDebugOpts();

        $returnData = array();

        $errorData = $this->errorData();

        if ($errorData) {

            $returnData = array('error' => $errorData);

        } elseif ($this->hasResponse) {

            if ($this->set('tokenResponse')) {
                $returnData = $this->response;
                if ($responseProp = prop($this->token, 'resProp')) {
                    $returnData = prop($this->response, $responseProp, null);
                }
            }

            elseif ($this->set('justResponse')) {
                $returnData = $this->response;
            }

            elseif ($this->set('fullResponse')) {

                $returnData['response'] = $this->response;

                if ($this->set('responseRequest')) {
                    $returnData['request'] = $this->getRequest();
                }

                if ($this->set('responseInfo')) {
                    $returnData['info'] = $this->info;
                }

                if ($this->set('responseToken')) {
                    $returnData['token'] = $this->token;
                }

            }

        } else {

            $returnData['msg'] = 'route not found';

            if (isMe) {
                $returnData['token'] = $this->token;
                $returnData['request'] = $this->getRequest(true);
                //$returnData['self'] = $this;
            }

        }







        return $returnData;
    }

    function reply(){
        $replyType = $this->set('replyType');
        if ($replyType == 'json') return $this->reply_json();
        if ($replyType == 'plain') return $this->reply_plain();
    }

    function reply_json(){
        $data = $this->responseData();
        _needphp('json/outputASJson');
        //dx($data, $this->cache);
        outputASJson($data, $this->cache, null, $this->prettyOutput);
    }

    function reply_plain(){
        $data = $this->responseData();
        headers('txt', 'utf8', 'nosniff', $this->cache);
        print_r($data);
        //outputASPlain($headers);

        //mb_get_info()
        //mb_regex_encoding()
    }

    public function get($path, $data = null){
        $this->run('get', $path, $data);
    }

    public function post($path, $data = null){
        $this->run('post', $path, $data);
    }

    public function put($path, $data = null){
        $this->run('put', $path, $data);
    }
    public function patch($path, $data = null){
        $this->run('patch', $path, $data);
    }

    public function delete($path, $data = null){
        $this->run('delete', $path, $data);
    }

    function run($method = true, $path = true, $data = true){

        if ($method === true) $method = $_SERVER['REQUEST_METHOD'];
        $this->handleMethod($method);

        if ($path === true) $path = pageUri;
        $this->handleUri($path);

        $this->handleEmuMethod();

        if ($data === true) $data = self::methodData($this->method, $this->emuRest);
        $this->handleData($data);

        $this->handlePath($this->path);

        //$this->handleCtx();

        $this->handleRequest();
    }

    private function handleUri($uri){
        $this->uri = $uri;
        $this->path = preg_replace("~^{$this->pathStart}/~", '', $this->uri);
        //dx($uri, $this->path);
    }

    private function handleMethod($method){
        $this->method = strtolower($method);
    }

    private function handleEmuMethod(){
        $emuMethod = strtok($this->path, '/');
        $this->emuRest = in_array($emuMethod, array('get', 'post', 'put', 'patch', 'delete'));
        if ($this->emuRest) {
            $this->method = $emuMethod;
            $this->path = preg_replace("~^$emuMethod/~", '', $p_b = $this->path);
            //dx($this->path, $p_b);
        }
    }

    private function handleData($data){
        $this->data = $data;
    }

    private function handlePath($path, $tokenStart = false){
        $this->path = $path;

        /*
        //[is pathPage, pathDir - так как исполбзуется только tokenPath и tokenPage]
        //[rn - перенести разбор tokenPage сюда, вторым аргументом]
        if (substr($path, -1) === "/") { //заканчивается на /
            $this->pathPage = '';
            $this->pathDir = rtrim($path, '/');
        } else {
            $this->pathPage = basename($path);
            $this->pathDir = dirname($path);
        }
        */

        if (is_string($tokenStart)) {
            $this->tokenStart = $tokenStart; //trim($tokenStart, '/')
            //$path = trim($this->path, '/');
            $this->tokenPath = preg_replace("~^{$tokenStart}/?~", '', $path);
            $this->tokenPath = trim($this->tokenPath, '/');
            $this->tokenPage = strtok($this->tokenPath, '/');
            $this->tokenPageSeq = preg_replace("~^{$this->tokenPage}/?~", '', $this->tokenPath);
        }

    }



    function data(){
    	$data = $src = $this->data;
    	return $data;
    }
	function data_has($propName){
		return array_key_exists($propName, $this->data);
	}
    function data_prop($propData, $otherwise = null){
    	return prop($this->data(), $propData, $otherwise);
    }

}

/*

//$api->addResponseProp('data', $response, true);
//$api->tokenResponse($response, 'data', true);


*/


/*[id]
    добавить метод 'sys'
        вариант для только системного обращения
            работает через api, но не доступно из вне
*/