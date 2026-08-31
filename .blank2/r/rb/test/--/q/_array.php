<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

_needphp('fq/_array');
//dx(_array(array('a' => '2')));

_needphp('fq/args_arr');

d(args_arr('a', '2', '3'));
d(args_arr('a', '2', array('3' => '4')));

d(argsArr('a', '2', '3'));