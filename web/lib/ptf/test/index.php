<?

include_once $_SERVER['DOCUMENT_ROOT'].'/web/iq.inc';

_lib('ptf');
DBHelper::$dbConfig['print_config'] = true;

d(mysql_conf());
include LIB.'/ptf/ptf-master/sample.php';
