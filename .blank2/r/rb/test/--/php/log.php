<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

_needphp('log');

_log('запись', 'данные');

dx(
	log::typeFilter(),
	log::getData()
);