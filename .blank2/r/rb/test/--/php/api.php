<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
//_rt::need('api'); //defined in pro.php

if (true) {
	_api::addRoute('user', array('rp', 'user'));

	//dx(_api::get('user/test'));
	//dx(_api::user('test'));
	dx(_api::user());
}


