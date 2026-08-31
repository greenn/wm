<?#0.1

class r_html {

    var $value; // \var $last_gen_value;

    function __construct($value) {
        $this->value =  is_string($value) ? $value : '';

        if (is_array($value)) {

        }
    }


    function value(){
        return $this->value;
    }
}