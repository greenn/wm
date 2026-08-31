<?
# api/rw/tool-log/test

usleep(500 * 1000); //500 миллисекунд (полсекунды) https://bit.ly/2IZ73qt
_log('log-test', array(
	'tmp' => $tmp = time(),
	'date' => date('y-m-d H:i:s', $tmp)
));
return array('log' => 'ok', 'tmp' => $tmp);