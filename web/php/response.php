<?#1.1

_needphp('api', 'w');

function response($msgList){
    $data = new responseData(array('msg' => $msgList));
    $data->res(null);
    return $data;
}


class responseData { //responseData|ok_response|
    function __construct($conf = array()){
        $this->set($conf);
    }

    function set($conf){
        if ($tplData = prop($conf, 'msg')) {
            $this->msgData($tplData);
        }
        if ($wData = prop($conf, 'w')) {
            $this->wData($wData);
        };
    }

    var $w = array(
        'item' => 'элемент'
    );
    function w($type, $prm = false, $opt = false){
        $res = $type;
        if ($w = prop($this->w, $type)) {
            $res = w($w, $prm, $opt);
        }
        return $res;
    }
    function wData($data){
        if (is_array($data)) {
            $this->w = array_replace($this->w, $data);
        }
    }


    var $msgTpl = array(
        'ED0' => 'Нет данных',
    );
    function msgData($data){
        if (is_array($data)) {
            $this->msgTpl = array_replace($this->msgTpl, $data);
        }
    }

    private $msg_ctx;
    function msg($tplCode, $ctx = array(), $ctxInRes = false){
        $msg = $tplCode;
        if ($tpl = prop($this->msgTpl, $tplCode)) {
            # https://regex101.com/r/hav7Y1/1/
            $this->msg_ctx = $ctx;
            $res = preg_replace_callback('~%([^%]+)%~', 'self::msg_callback', $tpl); //dx($res);
            if (is_array($res)) dx($res);
            if ($res) $msg = is_array($res) ? $res[0] : $res;
        }
        $res = array('msg' => $msg, 'code' => $tplCode);
        if ($ctxInRes) $res['ctx'] = $ctx;
        return $res;
    }
    function msgArg($args, $slice = 0) {
        $msgArgs = $slice ? array_slice($args, $slice) : $args;
        return call_user_func_array(array($this, 'msg'), $msgArgs);
    }
    function strMsg($tplCode, $ctx = array()) {
        $msg = $this->msg($tplCode, $ctx);
        return $msg['msg'];
    }
    private function msg_callback($match){
        $res = $match[0];
        $def = explode('/', $match[1]);
        $mdf = explode('|', $def[1]); //case: item / item|r|u
        $def[1] = $mdf[0];
        switch ($def[0]) {
            case 'x': { //context
                $res = '';
                $xo = $def[1] - 1; //context order-index
                //d($this->msg_ctx);
                if (has_prop($this->msg_ctx, $xo)) { //case: has ctx-element with that index
                    $x = $this->msg_ctx[$xo];
                    $res = is_stringable($x) ? $x : var_export($x, true);
                    $res = mb_strimwidth($res, 0, 25, '…');

                    foreach ($mdf as $i => $m) if ($i > 0) switch ($m) {
                        case 'q': $res = "'$res'"; break;
                        case 'qq': $res = "\"$res\""; break;
                        //case 't': $res = '{'.gettype($x).':'.mb_strimwidth(var_export($x, true), 0, 8, '…').'}'; break;
                        case 't': $res = '{'.gettype($x).'}'; break;
                        default: {

                            //https://regex101.com/r/215mNC/1/
                            if (preg_match_all('~([^?]+)[?]([^:]+)[:](.+)~', $m, $match, PREG_SET_ORDER)){
                                //case: condition ? :
                                list($str, $cond, $then, $else) = $match[0];
                                $pass = true;
                                switch ($cond) {
                                    case 'has': $pass = $x === '0' || $x === 0 || !empty($x); break;
                                    default: d($cond);
                                }
                                $res = $pass ? $then : $else;
                            } elseif (is_callable($w_m = "word::m_$m")) {

                                $res = call_user_func($w_m, $x);

                            } else {
                                d($m);
                            }

                        }
                    }

                }
            } break;
            case 'w': { //words
                //cases: item / item|r|u
                $res = call_user_func_array(array($this, 'w'), $mdf);
            } break;
        }
        //d($res);
        return $res;
    }

    private $resmsg = array();
    function resmsg($msgName, $msgCode, $msgCtx = array(), $ctxInRes = false){
        $msg = $this->msg($msgCode, $msgCtx, $ctxInRes);
        $this->resmsg[$msgName] = $msg;
        //ещё ничего не возвращали
    }


    private $info = array();
    function info($code/*, c, t, x*/){
        $ctx = array_slice(func_get_args(), 1);
        $info = $this->msg($code, $ctx, true);
        $this->info []= $info;
    }
    function setInfo($stack){
        //dx($stack);
        if (is_array($stack)) foreach ($stack as $infoArgs) { //$infoCtx
            call_user_func_array(array($this, 'info'), (array)$infoArgs);
        }
    }
    
    
    private $acts = array();
    function act($type, $code/*, c, t, x*/){
        $ctx = array_slice(func_get_args(), 2);

        $act = array('type' => $type);
        $act += $this->msg($code, $ctx, true);

        $this->acts []= $act;
    }
    function flush_acts() {
        $acts = $this->acts; //dx($acts);
        $this->acts = array();
        return $acts;
    }
    function setActs($stack){
        if (is_array($stack)) foreach ($stack as $actArgs) {
            call_user_func_array(array($this, 'act'), $actArgs);
        }
    }

    
    var $errorsWithCtx = true;
    private $errorHandler = false;
    private $errors = array();
    function errorArgs($args = array()){
        call_user_func_array(array($this, 'error'), $args);
    }
    function error($code = 'E'/*, c, t, x*/){
        $ctx = array_slice(func_get_args(), 1);
        $msg = $this->msg($code, $ctx, $this->errorsWithCtx);
        //dx($code, $ctx, $msg);

        if ($this->errorHandler) { //is_callable()
            call_user_func($this->errorHandler, $msg, $ctx);
        } else {
            $this->errors []= $msg;
        }
    }
    function setErrors($stack){
        //d($stack);
        if (is_array($stack)) foreach ($stack as $errorArgs) {
            $this->errorArgs((array) $errorArgs);
        }
    }
    function flush_errors($prepare = false) {
        $errors = $this->errors; //dx($errors);
        $this->errors = array();
        if ($prepare) {
            $errors = $errors ? (count($errors) == 1 ? $errors[0] : $errors) : false;
        }
        return $errors;
    }


    function state($slice = false) {
        $state = array(
            'acts' => $this->acts,
            'errors' => $this->errors,
            'info' => $this->info,
            'res' => $this->res,
        );
        return $slice ? prop($state, $slice) : $state;
    }
    function state_ok() {
        $state = $this->state();
        return !$state['acts'] && !$state['errors'] && !$state['info'];
    }



    private $res_prev = array(); //интересно-для-чего
    private $res = array();
    static $empty_res = array('ok' => false);
    function res($arg = false){
        if ($n = func_num_args()) {
            if ($n === 1) {
                //dx($arg);
                if (is_bool($arg)) {
                    $this->res['ok'] = $arg;
                } elseif (is_array($arg)) {
                    if (isset($arg['errors'])) {
                        $this->setErrors($arg['errors']);
                        unset($arg['errors']);
                    }
                    if (isset($arg['acts'])) {
                        $this->setActs($arg['acts']);
                        unset($arg['acts']);
                    };
                    if (isset($arg['info'])) {
                        $this->setInfo($arg['info']);
                        unset($arg['info']);
                    };

                    $this->res = array_replace($this->res, $arg);
                } elseif (is_null($arg) ) {
                    //dx($this->res, $this->res_prev);
                    if ($this->res) $this->res_prev []= $this->res;
                    $this->res = static::$empty_res;
                } elseif (is_stringable($arg)) {
                    //case: return $res value
                    return isset($this->res[$arg]) ? $this->res[$arg] : null;
                }

            } else {
                $res = call_user_func_array('argsArr', func_get_args());
                $this->res($res);
                if ($n == 2) {
                    /* case: сохранение одного поля, поэтому возвращаем только его значение, вместо полученного массива данныз
                        [eg] if ($op->res('userExist', $userExist['ok'])) {}
                            если нужен как массив, можно подать что-то третьи параметром
                                оно не войдёт в массив, но и не вернёт только value, т.к. $n !== 2
                    */
                    return $res[$arg];
                }

                return $res; //case возвращаем массив данных, которые добавлись в response

            }
        }
        return $this->res;
    }
    function res_($resType, $res, $forceRename = false){
        $data = $res;
        if (is_array($res)) {
            $data = array();
            foreach ($res as $prop => $value) {
                $isHiddenProp = $prop[0] == '_';
                if ($isHiddenProp || $forceRename) {
                    if (!$isHiddenProp) $prop = "_$prop";
                    $data["_$resType$prop"] = $value;
                } else {
                    $data[$prop] = $value;
                }
            }
        }
        return $this->res($data);
    }
    static function is_ok($res) {
        return is_array($res) ? prop($res, 'ok') : $res;
    }
    function res_ok(){
        return $this->state_ok() && $this->res('ok');
    }

    //данные предваряемые _ не отображаются, еслии не указаны в провайдере
    static function res_filter(&$data, $provide = false){
        if (is_array($data)) {
            $res = array();

            $provideAll = $provide === true;
            if (!is_array($provide)) $provide = $provide ? array($provide) : array();
            if (isOrdinal($provide)) $provide = merge_keys_value($provide, $provide);
            //d($provide);

            foreach ($data as $prop => $value) {
                if (array_key_exists($prop, $provide)) {
                    $rename = $provide[$prop];
                    if ($rename === true && $prop[0] === '_') $rename = substr($prop, 1);
                    if ($rename) $res[$rename] = $value;
                } elseif ($prop[0] !== '_' || $provideAll) {
                    $res[$prop] = $value;
                }
            }

            $data = $res;
        }
        return $data;
    }

    function response($provide = false){
        $res = array('ok' => false);
        if ($this->state_ok()) {
            $res = $this->res;
            if ($this->resmsg) $res['msg'] = $this->resmsg; //msg_list|msg_name|
            static::res_filter($res, $provide);
        } else {
            if ($this->resmsg) $res['msg'] = $this->resmsg;
            if ($this->errors) $res['error'] = api::makeMultiData($this->errors);
            if ($this->acts) $res['act'] = api::makeMultiData($this->acts);
            if ($this->info) $res['info'] = api::makeMultiData($this->info);
        }
        return $res;
    }
}