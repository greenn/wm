<?#1.16

//использование линковки свойств с помощью функции pl()

/*
    [eg] /web/test/web/php/pl.php
*/

_needphp('dataPath');

function mapProps($array){ #w: dataMap
    return pl::map($array);
}

function valProp($pl, $context){
    return pl::map($pl, $context);
}

function pathProp($dp, $context){
    $pl = call_user_func_array('pl', $dp);
    return valProp($pl, $context);
}


//property link
function pl(){
    $args = func_get_args();
    $pl = new ReflectionClass('pl');
    $pl = $pl->newInstanceArgs($args);
    return $pl;
}

//property link
class pl {
    var $dataPath;

    function __construct() {
        $this->dataPath = func_get_args();
    }
    function __toString() {
        return self::string($this->dataPath);
    }
    static function string($value){
        return (string)join('.', (array)$value);
    }


    var $array;
    function applyWith($array = null){
        $this->array = $array;
        $path = $this->dataPath;
        $value = dataPath2($path, $array, array($this, 'error'));
        return ple::type($value) ? $value->string() : $value;
    }
    function error($msg, $data = array()){
        $data['pathOrg'] = $this->dataPath;
        $data['ctxOrg'] = $this->array;
        return new ple($msg, $data);
    }
    function __invoke($array = null) {
        return $this->applyWith($array);
    }


    static function map($value, $context = null){
        self::track('reset');
        if (func_num_args() == 1) $context = $value;
        $res = self::mapValue($value, $context);
        self::track('reset');
        return $res;
    }
    static function mapValue($value, $context){
        if (self::type($value)) {
            $value = self::parse($value, $context);
        } elseif (is_array($value)) {
            foreach ($value as $name => &$prop) {
                $prop = self::mapValue($prop, $context);
            }
        }
        return $value;
    }
    static public function type($value){
        return $value instanceof self;
    }
    static function parse($pl, $context){
        if (self::track('has', $pl)) {
            $value = new ple('recursion property', array('pl' => $pl, 'track' => self::track('get')));
            return $value->string();
        } else {
            $value = $pl->applyWith($context);
            //$value = '{yes}';
            return self::mapValue($value, $context);
        }
    }
    static function track($cmd){
        static $track = array();
        switch ($cmd) {
            case 'reset': $track = array(); break;
            case 'add': $track []= func_get_arg(1); break;
            case 'has': return in_array(func_get_arg(1), $track);
            case 'get': return $track;
        }
    }
}


function ple(){
    $args = func_get_args();
    $pl = new ReflectionClass('ple');
    $pl = $pl->newInstanceArgs($args);
    return $pl;
}
//property link error
class ple {
    var $type;
    var $data;

    var $pathTail;
    var $ctxTail;
    var $origCtx;
    var $origPath;
    function __construct($type = 'error', $data) {
        $this->type = $type;
        $this->data = $data;
        d($type, $data);
    }
    static public function type($value){
        return $value instanceof self;
    }
    function __toString() {
        return $this->string();
    }
    function __invoke($array = null) {
        return $this->string();
    }
    function string(){
        return '{'.$this->type.'}';
    }
}