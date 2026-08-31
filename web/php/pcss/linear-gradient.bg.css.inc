<?
$arg[0] = 'linear-gradient';
$val = call_user_func_array('pcss', $arg);
print strtr($val, array(
    'background-image' => 'background'
));