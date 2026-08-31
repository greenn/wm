<?#0.1.7
/*
	ak mysqli | mysql instance
*/

_addphp('mysql/mysql_conf');

function mysql_i(/*$Mysql|$dbConf = null*/){
	static $obj = false;

	$case = func_num_args();

	if ($case === 1)  {
		$arg = func_get_arg(0);
		if ($arg === true) { //case: подключиться к настройками по-умолчанию
			$arg = mysql_conf(true);
			//$arg = array_slice($arg, 0, 3); //без подключения к конкретной базе данных
		}
		if (is_array($arg)) {
			dx('mysql_i::mysqli_connect', $arg);
			$obj = @call_user_func_array('mysqli_connect', $arg);
			//ak $Mysql = @new mysqli($host, $username, $userpass);
		} else if ($arg instanceof mysqli) {
			$obj = $arg;
		}
	}

	return $obj;
}