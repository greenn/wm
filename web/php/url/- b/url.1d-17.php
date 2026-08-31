<?//1d-17
// br: есть вопросы: а что и где и когда мы тут делаем ?
	//хороший вопрос

_needphp('urlToken');


function url($method = true){
    static $self = null;
    if (!$self) {
        $self = new _urlToken(URL);
    }
    $response = $self;

    $hasArguments = func_num_args() > 0;
    $arguments = func_get_args();
    if (!$hasArguments && is_integer($method)) {
        $hasArguments = true;
        $arguments = array($method);
        $method = 'get';
    }

    switch ($method) {
        case 'opt';
            if ($hasArguments && is_integer($arguments[0])) {
                $method = 'optN';
            }
            break;
    }

    $selfMethod = array($self, $method);

    //if (call_user_func_array('method_exists', $selfMethod))
    if (method_exists($self, $method)) {
        $response = call_user_func_array($selfMethod, $arguments);
    }

    return $response;




}
/*

url(1) ~ $self->get(1);
url('opt', 1) ~ is_number ? $self->optn(1) : $self->opt('1');
url('relative', $url)->max(1)  ~ $self->relative($url)
url('relative')->max(1)  ~ $self->relative(caller)

*/
