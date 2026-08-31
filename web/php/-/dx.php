<?//1.1

_needphp('d');

//call debug-kint d and do exit

function dx(){
	call_user_func_array('d', func_get_args());
	exit;
}