<?#

//переработать + тесты
function sv($name, $defaultValue = array()){
    return new sessionVariable($name, $defaultValue);
}

class sessionVariable {
    var $name;
    var $defaultValue = array();
    function __construct($name, $defaultValue = array()) {
        $this->name = $name;
        $this->defaultValue = $defaultValue;

        if (!sHas($name)) {
            s($name, $defaultValue);
        }
    }
    function remove(){
        sDel($this->name);
    }
    function clean(){
        s($this->name, $this->defaultValue);
    }
    function __set($prop, $val){
        $var = s($this->name);
        $var[$prop] = $val;
        s($this->name, $var);
    }
    function __get($prop){
        if ($this->has($prop)) {
            $var = s($this->name);
            return $var[$prop];
        } else
            return null;
    }
    function has($prop){
        $var = s($this->name);
        return isset($var[$prop]);
    }
    function __call($prop, $arguments){}

}