<?
/*mb
	mv iq/php/rw-list.inc
	+
		_api::addRoute('log', array('rw', 'tool-log'));
		_api::addRoute('admin', array('rw', 'tool-admin'));
*/
include_once $_SERVER['DOCUMENT_ROOT'].'/iq/tool/log/tool-log.class.php'; # api/rw/tool-log/test
include_once $_SERVER['DOCUMENT_ROOT'].'/iq/tool/admin/tool-admin.class.php';