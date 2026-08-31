<?#0.1
// формирование объекта с api-доступом по конфигурации из схемы данных
//  [oo _scheme.makeApi / web/js/web/lay/scheme.js.inc]
//  [eg web/test/php/scheme/scheme_api.php]

_needphp('api', 'textTemplate', 'set');

class scheme_api {

    var $conf = array(); //request|call|
    function __construct($scheme) {
        $apiConf = prop($scheme, 'api'); //dx($this->apiConf, $scheme);

        if ($apiConf) foreach ($apiConf as $requestName => $conf) {
            $this->conf[$requestName] = $this->decrypt($conf);
        }
    }

    function __call($name, $arguments) {
        if ($conf = prop($this->conf, $name)) {
            $ctx = $this->assertArgs($conf, $arguments);
            $method = $conf['method'];
            $addr = $this->makeAddr($conf['pattern'], $ctx);
            return api($method, $addr, $ctx->opt('#data'));
        }
    }

    var $decryptor = array('method', 'pattern', 'args');

    function decrypt($data) {
        $res = array();
        foreach ($data as $index => $value) {
            $name = prop($this->decryptor, $index, $index);
            $res[$name] = $value;
        }
        return $res;
    }

    function makeAddr($pattern, $ctx){
        $addr = textTemplate($pattern, $ctx);
        return $addr;
    }

    //$conf - заявленный порядок аргументов
    function assertArgs($conf, $argsData){ //spread/arrange
        $ctx = set(array('#data' => array()));

        foreach ($argsData as $index => $value) {
            $name = prop($conf, $index);

            if ($name === true) $name = '#data';
            if (!$name)  {
                if (!$ctx->hasSetOpt('#data')) $name = '#data'; //первый после заявленных аргументов (в $conf)
                else $name = $index;
            }

            $ctx->setOpt($name, $value);
        }

        if (!is_mixed($data = $ctx->opt('#data'))) { //0
            $ctx->setOpt('#data', make_arr('#data', $data));
        }
        return $ctx;
    }



}
