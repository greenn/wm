<?#0.3.1
// схема данных
// стандартизирует работу с данными
_needphp('api', 'set');
require_once PHP.'/scheme/scheme_api.php';

function scheme($schemeData, $opts = false){ //$opts ~ initOpts
    $scheme = false;

    if (is_string($schemeData)) {
        $schemeData = api('get', "scheme/$schemeData");
    }
    $class = 'scheme';
    if ($type = prop($schemeData, 'type')) {
        $class .= "_$type";
    }

    if (class_exists($class)) {
        $scheme = new $class($schemeData, $opts);
    }

    return $scheme;
}

class scheme {

    function __construct($conf, $initConf = false) {
        $this->setConf($conf);
        $this->set = set($this->set);

        $this->init = set();
        $this->init($initConf);

        //if ('arg2') $this->data = new crud_json(array('scheme' => $this));
    }

    var $type;// = 'object';
    var $fields = array();
    var $w = array();
    var $sd = array();
    var $api = false; //api-conf | scheme_api{}
    var $data; //crud_json{}
    var $set = array();

    //проверяет активна ли опция $opt у поля $fieldName
    function field_is($fieldName, $opt){
        $field = prop($this->fields, $fieldName);
        $state = prop($field, $opt);
        return $state;
    }



    var $conf;
    function setConf($conf) {
        $this->conf = $conf;
        foreach ($conf as $prop => $value) {
            $this->{$prop} = $value;
        }
    }


    var $init;
    function init($conf){
        if (is_true($conf)) $conf = array('api', 'data');
        else if (is_string($conf)) $conf = array($conf);
        $this->init->set($conf);

        if ($this->init->api) {
            $this->api = new scheme_api($this->api);
        }

        if ($this->init->data) {
            $this->data = new crud_json(array('dataScheme' => $this->conf));
        }

    }

    //static function verifyField($field, $value){}

    //0 qjb
    private function verify_new(&$res, $field, $name, $value, $has_value){
        //dx($name, $names, $value, $data);
        if ($req = prop($field, 'is_required')) {
            if ($has_value) {
                if (empty($value)) {
                    d(11);
                    $res['errors'] []= array('EV1', $name, $value); //data validation
                    $value = false;
                    //continue;
                } // else case: ok
            } else {
                $res['errors'] []= array('EV0', $name); //data miss
                $value = null;
                //continue;
            }
        }/* else { //
            if (!$has_value) {
                //static::fieldDefValue($set);
                $value = '';
            }
        }*/

        $res['_data'][$name] = $value;
    }

    private function verify_upd(&$res, $field, $name, $value, $has_value){
        //d($res, $field, $name, $value, $has_value);
        $req = prop($field, 'is_required');
        if ($has_value) {
            if ($req && empty($value)) { //case: попытка обновить required-данные пустым значением
                $res['errors'] []= array('EV1', $name, $value); //data validation
            } else {
                $res['_data'][$name] = $value;
            }
        }
    }

    function verify($data, $mode){ //aka verify_object
        $set = $this->set;
        $res = array('ok' => true, 'errors' => array(),
            '_data' => array(),
            '_fields' => $this->fields,
        );

        if (!is_array($data)) { // || empty($data)
            $res['errors'] []= array('ED2', gettype($data)); //data error
        } else {
            //if ($this->fields) {
            $verify_handler = array($this, "verify_$mode");
                foreach ($this->fields as $name => $field) {

                    //id-ключ не учитываем
                    $type = prop($field, 'type');
                    if ($type == 'id') continue;

                    //возможное использование других имён для текущего $name
                    $names = prop($field, 'names') ? array_merge(array($name), (array) $field['names']) : $name;
                    $has_value = has_prop($data, $names); //[id array($name, $field->nameVariants)]
                    $value = prop($data, $names, '');

                    call_user_func_array($verify_handler, array(&$res, $field, $name, $value, $has_value));
                        //http://php.net/manual/ru/function.call-user-func.php#example-6244
                }
            //}
            //возможно использование неописанных полей, в качестве дополнительных данных
            if ($set->allowExtension) {
                $allow = is_array($set->allowExtension) ? $set->allowExtension : array_keys($data);
                foreach ($allow as $prop) {
                    if (isset($data[$prop]) && !isset($res['data'][$prop])) {
                        $res['_data'][$prop] = $data[$prop];
                    }
                }
            }
        }

        if ($mode === 'upd') {
            //dx($res);
            //if (empty($res['_data'])) $res['errors'] []= array('EU0');
            if (empty($res['_data'])) {
                $res['info'] []= array('IU0');
                $res['ok'] = false;
            }
        }


        if (!empty($res['errors'])) {
            $res['ok'] = false;
        }

        return $res;
    }

    function verifyUnique($data, $list){
        $res = array('ok' => true, 'errors' => array(), 'acts' => array());
        if (is_array($data) && is_array($list)) if ($set = $this->set->unique) {
            $fields = $this->fields;

            if ($set === true) $set = merge_keys_value(array_keys($fields), true);
            if (is_string($set)) $set = array($set => true);
            if (isOrdinal($set)) $set = merge_keys_value($set, true);

            $list = array_slice($list, 1); //first element is info-object
            //dx($set, $this);
            if (is_array($set)) {
                foreach ($set as $fieldName => $uniqueCond) {
                    $foundSame = array();
                    if (has_prop($data, $fieldName)) {
                        $fieldValue = $data[$fieldName];
                        $notEmpty = $fieldValue !== '';
                        $allowEmpty = !$this->field_is($fieldName, 'is_required');
                        if ($notEmpty && !$allowEmpty) {
                            //case: поле может быть уникально, но не обязательно
                            //  тода пустое значение не учитываем и поле не верефицируем (не сравниваем с другими)
                            $idName = $this->getIdName();
                            foreach ($list as $index => $item) {
                                if (has_prop($item, $fieldName)) {
                                    if ($item[$fieldName] === $fieldValue) {
                                        $foundSame []= $item[$idName];
                                    }
                                }
                                //else: возможная ошибка данных / в проверяемом нет уникального поля
                                    //mean: перед этим не проводилась verify()
                            }
                        }
                    }
                    //else: возможная ошибка данных / в проверяющем нет уникального поля
                        //mean: в существующем листе, есть неправильные данные

                    if (!empty($foundSame)) {
                        if ($uniqueCond === true) {
                            $res['errors'] []= array('EV2', $fieldName, $fieldValue, $foundSame);
                        } elseif ($uniqueCond === 'confirm') {
                            $res['acts'] []= array('confirm', 'AVC', $fieldName, $fieldValue, $foundSame);
                        }

                    }
                }
            }

            if (!empty($res['errors']) || !empty($res['acts'])) {
                $res['ok'] = false;
            }
        }


        return $res;
    }

    function verifyChanges($item, $data){
        $res = array('ok' => true, '_data' => $data, '_target' => $item, '_new' => array(), 'errors' => array(), 'info' => array());

        foreach ($data as $prop => $value) {
            if (has_prop($item, $prop)) {
                if (serialize($item[$prop]) !== serialize($data[$prop])) {
                    $res['_new'][$prop] = $value;
                } //else case: даные не изменились
            } else { //case: доп. поля (при опции схемы {allowExtension})
                $res['_new'][$prop] = $value;
            }
        }

        //if (empty($res['_new'])) $res['errors'] []= 'EU1';
        if (empty($res['_new'])) {
            //$res['errors'] []= 'EU1';
            $res['info'] []= 'IU1';
            $res['ok'] = false;
        }
        elseif (empty($res['errors'])) $res['ok'] = true;

        return $res;
    }

    function getIdName(){
        foreach ($this->fields as $name => $field) {
            if (prop($field, 'type') == 'id') {
                return $name;
            }
        }
    }

    function setId(&$data, $id){
        $idName = $this->getIdName();
        $data[$idName] = $id;
    }
}

//class scheme_object extends scheme {}