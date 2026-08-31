<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
/*
	oo php/_s/sp.class.php
*/
_needphp('_s/init');

$nm = 'test-data';


$data = new sp('test-data', 'list', 'a');
$data->reset();

d($data, _s('test-data'));

$data->_push(11);
$data->_push(12);
dx(_s('test-data'));
