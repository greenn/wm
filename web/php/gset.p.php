<?//3-12
_needphp('gt');

function gset(){

    switch (func_num_args()) {
        case 0;
            //получение всех динамических-опций с текущими значениями
            $gOpts = array();
            $allOpts = _gset();
            foreach ($allOpts as $name => $val) {
                if (_gset(true, $name, "isDynamic")) {
                    $gOpts[$name] = _gset($name);
                }
            }
            return $gOpts;

        case 1:
            //получение значения динамической-опции
            $optName = func_get_arg(0);
            _gset($optName, "isDynamic", true);
            return _gset($optName);

        case 2:
            //установка значения для динамической-опции
            $optName = func_get_arg(0);
            $optValue = func_get_arg(1);
            _gset($optName, "isDynamic", true);
            _gset($optName, $optValue);
            return _gset($optName); #`
    }

}
function _gset(){
    static $optsStore = array();
    static $confStore = array();
    static $defConf = array(
        "default" => false,
        "isDynamic" => false,
    );

    switch (func_num_args()) {
        case 0;
            //получение всех опций с текущими значениями
            $opts = array();
            foreach ($optsStore as $name => $defValue) {
                $opts[$name] = _gset($name);
            }
            return $opts;

        case 1:
            //получение текущего значения опции
            $optName = func_get_arg(0);
            $optConf = isset($confStore[$optName]) ? $confStore[$optName] : $defConf;
            $optValue = isset($optsStore[$optName]) ? $optsStore[$optName] : $optConf['default'];
            return $optConf['isDynamic'] ? gt($optName, $optValue) : $optValue;

        case 2:
            //усановка значения для опции
            $optName = func_get_arg(0);
            $optValue = func_get_arg(1);
            $optsStore[$optName] = $optValue;
            return $optValue; #`

        case 3:
            //операции с конфигом для опции
            $optName = func_get_arg(0);
            if ($optName !== true) {
                //установка значения в конфиг для опции
                $confName = func_get_arg(1);
                $confVal = func_get_arg(2);
                $optConf = isset($confStore[$optName]) ? $confStore[$optName] : $defConf;
                $optConf[$confName] = $confVal;
                $confStore[$optName] = $optConf;
                return $optConf; #`
            } else {
                //получение значения конфига от опции
                $optName = func_get_arg(1);
                $confName = func_get_arg(2);
                $optConf = isset($confStore[$optName]) ? $confStore[$optName] : $defConf;
                $confVal = isset($optConf[$confName]) ? $optConf[$confName] : null;
                return $confVal; #`
            }
    }
}