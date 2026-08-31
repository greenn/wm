<?#0.2.5

/*
	github
		https://github.com/sushilman/ptf
*/

_needphp('mysql'); //конфигурация текущей базы данных

$ptfVersionDir = 'ptf-master';
$ptfDir = dirname(__FILE__)."/$ptfVersionDir";
//define('LIB_PTF', $ptfDir);

include_once("$ptfDir/helper/DBHelper.php");

DBHelper::$dbConfig = array(
	'dbhost' => mysql_conf('db_host'),
	'db' => mysql_conf('db_name'),
	'username' => mysql_conf('user_name'),
	'password'=> mysql_conf('user_pass'),
	'print_config'=> false
);

include_once("$ptfDir/model/modelMapper.php");
include_once("$ptfDir/model/baseModel.php");
include_once("$ptfDir/model/field.php");
include_once("$ptfDir/model/form.php");