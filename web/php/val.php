<?#2-1

_needphp('undef');

function val(){
    $result = undef();
    $argument_rec = null;
    $__type = val_();
    $index_lastArgument = func_num_args() - 1;
    $argument_first = $index_lastArgument > -1 ? func_get_arg(0) : $argument_rec;
    $arguments = func_num_args();


    switch($__type) {
        case 'fl'; //first -or- last
            $argument_last = $index_lastArgument > -1 ? func_get_arg($index_lastArgument) : $argument_first;
            $result = $argument_first ? $argument_first : $argument_last;
            break;

        case 'hasTrue'; //first true
            $hasTrue = false;
            while($arguments && !$hasTrue) {
                $hasTrue = array_shift($arguments) === true;
            }
            $result = $hasTrue;
            break;
    }

    return $result;
};

function val_(){
    static $type;
    if (func_num_args()) {
        $val = func_get_arg(0);
        $list = array('fl', 'hasTrue');
        $type = in_array($val, $list)? $val : $list[0];
    }
    return $type;
}

function _val(){
    $arguments = func_num_args();
    val_(array_shift($arguments));
    $result = call_user_func_array('val', $arguments);
    val_(0);
    return $result;
}

/*d



is_val function
    return is &val_val
    empty_val

d*/

/*
    WTT>?? кто этим пользуется ?

	и как эти пользоваться - примеры?
*/