<?#0.2.1
_needphp('fq/_args');

/*  eg
    $res1 = obj(array('sectionStart' => true, 'ctx' => $ctx));
    $res2 = obj('sectionStart', true, 'ctx', $ctx);
    //$res1 = $res2
*/

/*[ ts
	web/test/web/php/obj/array.php
]*/

function obj(){
    $args = func_get_args();

    if (count($args) === 1 && $args[0] instanceof obj) {
        return $args[0]; //case obj( $obj )
    }

    $obj = new ReflectionClass('obj');
    return $obj->newInstanceArgs($args);
}

class obj {

    function __construct() {
        $args = func_get_args();
        call_user_func_array(array($this, 'set'), $args);
    }

    function __get($prop) {
        return $this->get($prop, false);
    }

    function has($prop){
        return property_exists($this, $prop);
    }

    function get($prop, $otherwise = null){
        return $this->has($prop) ? $this->{$prop} : $otherwise;
    }

    function set(){
        $args = func_get_args();
        $data = argsArrArg($args);
        foreach ($data as $prop => $value) {
            $this->{$prop} = $value;
        }
        return $this;
    }

    //только добавляет свойство, которых нет, не заменяет в отличии от set []
    function add($data){
        $args = func_get_args();
        $data = argsArrArg($args);
        foreach ($data as $prop => $value) {
            if (!$this->has($prop)) {
                $this->{$prop} = $value;
            }
        }
        return $this;
    }
}

