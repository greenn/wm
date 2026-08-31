<?#5.2.0
/*[eg
	web/test/web/php/set.php
	web/test/web/php/set.php?a=3
]*/

_needphp('isAssoc', 'fq/_merge');
/*
	?bool - использование get-параметров, как значения настроек
	{a}?default-data
	*{*}данные настроек
	[eg
		$set->info() - информация о значения

		set('prop');
		set('prop', 'propVal');
		set(array('prop1', 'prop2'));
		set(array('prop' => 'val'));
		set(true, ...); //$useDynamic = true
		set(null, ...); //$def = null
		set(true, null, array('prop1'), array('prop2')); - useDynamic: true, defaults: false, options: { prop1: true, prop2: true }
	]
*/
/*  [ff-dd]
	setRule - устанавливать правила для переменных
			например значеие может быть только массив
			то есть $dynamic и $data оставлять как есть,
			а $options обсчитывать уже с учётом
		var $rule
			->setRule('ext', 'only array'))
			->setRule('ext', array('only' => array()))

		eg
*/
function set(){
    $useDynamic = null;
    $def = false;
    $conf = array();
    $args = func_get_args();
    $n = func_num_args();
    $optName = false;
    $lookDynamic = true; //pos = 0
    $lookDefault = false; //pos = 0 | 1 (after $lookDynamic)
    //$lookData = false; //флаг начала перечисления аргументов, как входящие данные
    for ($pos = 0; $pos < $n; $pos++) {
        $arg = $args[$pos];
	    if (!$optName) { //case look for option-name

		    if ($lookDynamic) {
			    $lookDynamic = false;
			    $lookDefault = true;
		    	if (is_bool($arg)) {
				    $useDynamic = $arg;
				    continue;
			    }
		    }

		    if (is_object($arg)) {
			    $arg = is_set($arg) ? $arg->options : (array) $arg;
		    }

		    if ($lookDefault) {
			    $lookDefault = false;
			    //$lookData = true;
		    	$isLastArg = $pos === $n - 1;
			    if (!$isLastArg) {
			    	if (is_mixed($arg)) {
					    $def = $arg;
					    //dx('defaultData', $arg);
					    continue;
				    }
				    if (is_null($arg)) { //case: array(null, {ao}, {ao}) указание, что данные не дефолтные
					    continue;
				    }
			    }
		    }

		    //$lookData
		    if (is_string($arg) || is_numeric($arg)) {
			    $optName = $arg;
			    $conf[$optName] = true; //case: если небудет следующего значения,
			    // если будет следующее значение, оно перепишет {t}
		    } elseif (is_array($arg)) {
			    $conf = array_merge_recursive($conf, $arg);
		    }

	    } else {
		    $conf[$optName] = $arg;
		    $optName = false;
	    }
    }

    $args = array();
    if (is_bool($useDynamic)) $args []= $useDynamic;
    if (is_array($def)) $args []= $def;
    $args []= $conf;
    //dx($useDynamic, $def, $conf, $args);
    $set = new ReflectionClass('set');
    return $set->newInstanceArgs($args);
}

function is_set($var){
    return is_object($var) && $var instanceof set;
}
function not_set($var){
    return !is_set($var);
}

function setArr($set = array()){
    return call_user_func_array('set', $set);
}
/*
    new set(true, $def, $opts);
    new set($def, $opts);
    new set($opts);
*/
class set {

    function __construct() {
        if ($args = func_get_args()) {

        	if ($hasDynamicOpt = is_bool($args[0])) {
        	    $_splice = array_splice($args, 0, 1);
        		$setDynamic = $_splice[0]; //оставляем $args без этой опции
		        $this->setDynamic($setDynamic);
	        }

	        if ($hasDefault = count($args) == 2) {
                $_splice = array_splice($args, 0, 1);
		        $setDefaults = $_splice[0];
		        $this->setDefaults($setDefaults);
	        }

			if ($hasData = $args) {
				$setData = $args[0];
				$this->setData($setData);
			}

	        //dx('set::construct', @$setDynamic, @$setDefaults, @$setData, func_get_args());
        }
    }

    var $default = false;
    function setDefaults($data, $update = false){
	    $data = static::arrayData($data);

	    if ($update && $this->default) { //$this->default: {f}|{a}
		    $data = array_replace($this->default, $data);
	    }

	    //dx('setDefaults', $data);
	    $this->default = $data;

	    $this->optionsUpdate();
    }
    //hasDefOpt

    private $useDynamic = false;
    private $dynamic = array();
    function setDynamic($state){
        $this->useDynamic = $state;
        $this->dynamicUpdate();
    }
    function dynamicUpdate(){
        $this->dynamic = $this->useDynamic ? $_REQUEST : array();
        $this->optionsUpdate();
    }

    static function arrayData($data){
	    $res = $data;

    	if (is_object($data)) {
		    $res = is_set($data) ? $data->options : (array) $data;
	    }

	    if (is_string($data)) {
		    $res = make_arr($data, true);
	    }

	    if (isOrdinal($data)) {

		    //$res = merge_keys_value($data, true);
		    //dx('arrayData', $data, $res);
	    }

	    //dx('arrayData', $data, $res);
	    return is_array($res) ? $res : array();
    }

    var $data = array();
    function setData($data){

        if ($data = static::arrayData($data)) {
        	//dx('setData', $data);
            $this->data = array_replace($this->data, $data);
            $this->optionsUpdate();
        }

        return $this;
    }
    function setOpt($name, $value = true){
        $this->data[$name] = $value;
        $this->optionsUpdate();
	    return $this;
    }

	function delOpt($name){
    	if ($this->hasSetOpt($name)) {
		    unset($this->data[$name]);
    	    $this->optionsUpdate();
	    }
		return $this;
	}

    function hasSetOpt($name){ // hasSetOpt|hadOpt|
        return array_key_exists($name, $this->data);
    }
    function set() {
        $data = array();

        $args = func_get_args();
        $n = func_num_args();
        $optName = false;
        for ($i = 0; $i < $n; $i++) {
            $arg = $args[$i];
            if ($optName) {
                $data[$optName] = $arg;
                $optName = false;
            } else {
                if (is_mixed($arg)) {
                    $data = array_merge($data, $arg);
                } elseif (is_stringable($arg)) {
                    $optName = $arg;
                } else {
                    //wrong params order
                }
            }
        }

        return $this->setData($data);
    }



    var $options = array();
    function optionsUpdate(){
        //array_merge не перезаписывает assoc ключи
        $this->options = array();
        //if ($this->override)
        if ($this->useDynamic) $this->options += $this->dynamic;
        $this->options += $this->data;
        if ($this->default) $this->options += $this->default;
    }
    function hasOpt($name){
        return array_key_exists($name, $this->options);
    }
    function getOpt($name){
        return $this->options[$name];
    }



    function opt($name, $otherwise = null){
    	//d('set/opt', $name, $this->hasOpt($name), $otherwise);
	    return $this->hasOpt($name) ? $this->getOpt($name) : $otherwise;
    }

	function optOr($name, $otherwise = null){
		$val = $this->getOpt($name);
		return $val ? $val : $otherwise;
	}

    function isOpt($name, $val) {
        return $this->hasOpt($name) && ($this->getOpt($name) === $val);
    }


    function __get($name) {
        return $this->opt($name);
    }

    function __set($name, $value) {
        $this->setOpt($name, $value);
    }

    //[походу так]$set->opt1_or(false); //0
    function __call($method, $args) {

        $name = $method;
        $flag = false;

        if (preg_match('~^(.+)_(.+)$~', $method, $matches)) {
            $name = $matches[1];
            $flag = $matches[2];
        }

        $callMethod = array($this, 'opt');
        $callArgs = array($name);


        if ($flag) switch ($flag) {
            case 'or':
                $callArgs []= array_key_exists(0, $args) ? $args[0] : null;
                break;
        }

        return call_user_func_array($callMethod, $callArgs);
    }

    function info(){
    	return array(
    		'useDynamic' => $this->useDynamic,
    		'default' => $this->default,
    		'data' => $this->data,
    		'options' => $this->options,
	    );
    }

    function cloneData($makeSet = true, $update = array()){
    	$data = $this->data;
    	if ($update) $data = array_replace($data, $update);
    	return $makeSet ? set($this->default, $data) : $data;
    }
}